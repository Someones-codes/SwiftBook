<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Placeholder stats for now.
        // These will be replaced with real Appointment queries in Milestone 5.
        $stats = [
            'today'     => 0,
            'upcoming'  => 0,
            'completed' => 0,
            'cancelled' => 0,
        ];

        return view('dashboard.index', compact('stats'));
    }
}
