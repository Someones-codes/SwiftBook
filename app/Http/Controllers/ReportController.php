<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;

class ReportController extends Controller
{
    public function index()
    {
        $today       = today();
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek   = $today->copy()->endOfWeek();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth   = $today->copy()->endOfMonth();

        $appointmentCounts = [
            'today'      => Appointment::whereDate('appointment_date', $today)->count(),
            'this_week'  => Appointment::whereBetween('appointment_date', [$startOfWeek, $endOfWeek])->count(),
            'this_month' => Appointment::whereBetween('appointment_date', [$startOfMonth, $endOfMonth])->count(),
        ];

        [$newCustomers, $returningCustomers] = $this->newVsReturningCustomers($startOfMonth, $endOfMonth);

        // withCount avoids an N+1 — one query gets every service plus its
        // appointment count, then we just sort the in-memory collection.
        $servicesByBookings = Service::withCount('appointments')
            ->orderByDesc('appointments_count')
            ->get();

        $mostPopular  = $servicesByBookings->take(5);
        $leastPopular = $servicesByBookings->sortBy('appointments_count')->take(5);

        return view('reports.index', compact(
            'appointmentCounts',
            'newCustomers',
            'returningCustomers',
            'mostPopular',
            'leastPopular',
        ));
    }

    /**
     * Among customers with an appointment this month, "new" means their
     * very first-ever appointment falls inside this month; "returning"
     * means they had at least one appointment before this month started.
     *
     * Note: this runs one extra query per active customer this month.
     * Fine at small-business volume (tens of customers/month) — if this
     * ever needs to scale to thousands, it should be rewritten as a
     * single grouped query instead.
     */
    private function newVsReturningCustomers($startOfMonth, $endOfMonth): array
    {
        $activeCustomerIds = Appointment::whereBetween('appointment_date', [$startOfMonth, $endOfMonth])
            ->distinct()
            ->pluck('customer_id');

        $newCount = 0;
        $returningCount = 0;

        foreach ($activeCustomerIds as $customerId) {
            $firstEver = Appointment::where('customer_id', $customerId)
                ->min('appointment_date');

            if ($firstEver >= $startOfMonth->format('Y-m-d')) {
                $newCount++;
            } else {
                $returningCount++;
            }
        }

        return [$newCount, $returningCount];
    }
}
