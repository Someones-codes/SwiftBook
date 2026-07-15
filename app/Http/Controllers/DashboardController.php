<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();

        $stats = [
            'today'     => Appointment::whereDate('appointment_date', $today)
                                ->where('status', '!=', Appointment::STATUS_CANCELLED)
                                ->count(),

            'upcoming'  => Appointment::whereDate('appointment_date', '>', $today)
                                ->where('status', '!=', Appointment::STATUS_CANCELLED)
                                ->count(),

            'completed' => Appointment::where('status', Appointment::STATUS_COMPLETED)->count(),

            'cancelled' => Appointment::where('status', Appointment::STATUS_CANCELLED)->count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
