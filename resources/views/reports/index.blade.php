<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Appointment counts --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointments</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="border border-gray-100 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Today</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $appointmentCounts['today'] }}</p>
                    </div>
                    <div class="border border-gray-100 rounded-lg p-4">
                        <p class="text-sm text-gray-500">This Week</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $appointmentCounts['this_week'] }}</p>
                    </div>
                    <div class="border border-gray-100 rounded-lg p-4">
                        <p class="text-sm text-gray-500">This Month</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $appointmentCounts['this_month'] }}</p>
                    </div>
                </div>
            </div>

            {{-- New vs returning customers --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Customers This Month</h3>
                <p class="text-xs text-gray-500 mb-4">Based on customers with at least one appointment this month.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="border border-gray-100 rounded-lg p-4">
                        <p class="text-sm text-gray-500">New Customers</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $newCustomers }}</p>
                    </div>
                    <div class="border border-gray-100 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Returning Customers</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $returningCustomers }}</p>
                    </div>
                </div>
            </div>

            {{-- Service popularity --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Most Popular Services</h3>
                    @if ($mostPopular->isEmpty())
                        <p class="text-sm text-gray-500">No bookings yet.</p>
                    @else
                        <ul class="divide-y divide-gray-100 text-sm">
                            @foreach ($mostPopular as $service)
                                <li class="py-2 flex justify-between">
                                    <span>{{ $service->name }}</span>
                                    <span class="text-gray-500">{{ $service->appointments_count }} booking{{ $service->appointments_count === 1 ? '' : 's' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Least Popular Services</h3>
                    @if ($leastPopular->isEmpty())
                        <p class="text-sm text-gray-500">No bookings yet.</p>
                    @else
                        <ul class="divide-y divide-gray-100 text-sm">
                            @foreach ($leastPopular as $service)
                                <li class="py-2 flex justify-between">
                                    <span>{{ $service->name }}</span>
                                    <span class="text-gray-500">{{ $service->appointments_count }} booking{{ $service->appointments_count === 1 ? '' : 's' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
