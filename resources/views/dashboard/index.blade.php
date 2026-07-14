<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Today's Appointments</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['today'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Upcoming</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['upcoming'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Completed</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['completed'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Cancelled</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['cancelled'] }}</p>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('customers.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        + Customer
                    </a>
                    <a href="{{ route('services.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        + Service
                    </a>
                    {{-- Appointment quick action will link here once Milestone 5 is built --}}
                    {{-- <a href="{{ route('appointments.create') }}">+ Appointment</a> --}}
                </div>
            </div>

            {{-- Calendar preview placeholder — populated in Milestone 6 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Calendar Preview</h3>
                <p class="text-sm text-gray-500">Calendar view coming in Milestone 6.</p>
            </div>

        </div>
    </div>
</x-app-layout>