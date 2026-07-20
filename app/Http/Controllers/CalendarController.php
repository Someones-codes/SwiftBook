<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    /**
     * Returns appointments as FullCalendar-compatible JSON events.
     * Cancelled appointments are excluded — an empty slot is more useful
     * to see on the calendar than a crossed-out one.
     */
    public function events()
    {
        $statusColors = [
            'pending'   => '#f59e0b', // amber
            'confirmed' => '#3b82f6', // blue
            'completed' => '#22c55e', // green
            'no_show'   => '#ef4444', // red
        ];

        return Appointment::with(['customer', 'service'])
            ->where('status', '!=', Appointment::STATUS_CANCELLED)
            ->get()
            ->map(function (Appointment $appointment) use ($statusColors) {
                $start = Carbon::parse(
                    $appointment->appointment_date->format('Y-m-d') . ' ' . $appointment->appointment_time
                );
                $end = $start->copy()->addMinutes($appointment->service->duration);
                $color = $statusColors[$appointment->status] ?? '#6b7280';

                return [
                    'id'              => $appointment->id,
                    'title'           => "{$appointment->customer->first_name} - {$appointment->service->name}",
                    'start'           => $start->toIso8601String(),
                    'end'             => $end->toIso8601String(),
                    // FullCalendar navigates the browser here on click —
                    // no separate eventClick handler needed.
                    'url'             => route('appointments.edit', $appointment),
                    'backgroundColor' => $color,
                    'borderColor'     => $color,
                ];
            });
    }
}
