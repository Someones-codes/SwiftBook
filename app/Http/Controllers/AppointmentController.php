<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $date   = $request->query('date');

        $appointments = Appointment::with(['customer', 'service'])
            ->when($status, fn ($query, $status) => $query->where('status', $status))
            ->when($date, fn ($query, $date) => $query->whereDate('appointment_date', $date))
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(15)
            ->withQueryString();

        return view('appointments.index', compact('appointments', 'status', 'date'));
    }

    public function create()
    {
        $customers = Customer::orderBy('first_name')->get();
        $services  = Service::where('active', true)->orderBy('name')->get();

        return view('appointments.create', compact('customers', 'services'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();

        $service = Service::findOrFail($data['service_id']);

        $conflict = $this->findConflict(
            date: $data['appointment_date'],
            time: $data['appointment_time'],
            durationMinutes: $service->duration,
        );

        if ($conflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' => "This slot overlaps with {$conflict->customer->first_name}'s "
                        . "{$conflict->service->name} appointment at "
                        . Carbon::parse($conflict->appointment_time)->format('H:i') . '.',
                ]);
        }

        $data['status'] = $data['status'] ?? Appointment::STATUS_PENDING;

        Appointment::create($data);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment booked successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['customer', 'service']);

        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $customers = Customer::orderBy('first_name')->get();
        $services  = Service::where('active', true)->orderBy('name')->get();

        return view('appointments.edit', compact('appointment', 'customers', 'services'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->validated();

        // Only re-check for conflicts if the appointment stayed active
        // (no point blocking a slot that's being cancelled anyway).
        if ($data['status'] !== Appointment::STATUS_CANCELLED) {
            $service = Service::findOrFail($data['service_id']);

            $conflict = $this->findConflict(
                date: $data['appointment_date'],
                time: $data['appointment_time'],
                durationMinutes: $service->duration,
                ignoreAppointmentId: $appointment->id,
            );

            if ($conflict) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'appointment_time' => "This slot overlaps with {$conflict->customer->first_name}'s "
                            . "{$conflict->service->name} appointment at "
                            . Carbon::parse($conflict->appointment_time)->format('H:i') . '.',
                    ]);
            }
        }

        $appointment->update($data);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment deleted.');
    }

    /**
     * Duration-aware overlap check.
     *
     * Two appointments overlap when: newStart < existingEnd AND newEnd > existingStart.
     * We pull that day's active appointments (excluding cancelled, and excluding
     * the appointment being edited) and compare each one's real end time —
     * calculated from ITS OWN service duration — against the new slot.
     */
    private function findConflict(
        string $date,
        string $time,
        int $durationMinutes,
        ?int $ignoreAppointmentId = null,
    ): ?Appointment {
        $newStart = Carbon::parse("{$date} {$time}");
        $newEnd   = $newStart->copy()->addMinutes($durationMinutes);

        $sameDayAppointments = Appointment::with(['customer', 'service'])
            ->whereDate('appointment_date', $date)
            ->where('status', '!=', Appointment::STATUS_CANCELLED)
            ->when($ignoreAppointmentId, fn ($query) => $query->where('id', '!=', $ignoreAppointmentId))
            ->get();

        foreach ($sameDayAppointments as $existing) {
            $existingStart = Carbon::parse($existing->appointment_date->format('Y-m-d') . ' ' . $existing->appointment_time);
            $existingEnd   = $existingStart->copy()->addMinutes($existing->service->duration);

            $overlaps = $newStart->lt($existingEnd) && $newEnd->gt($existingStart);

            if ($overlaps) {
                return $existing;
            }
        }

        return null;
    }
}
