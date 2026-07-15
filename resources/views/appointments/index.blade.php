<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <form method="GET" action="{{ route('appointments.index') }}" class="flex flex-wrap gap-3">
                        <select name="status" onchange="this.form.submit()"
                                class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">All statuses</option>
                            @foreach (\App\Models\Appointment::STATUSES as $statusOption)
                                <option value="{{ $statusOption }}" {{ $status === $statusOption ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $statusOption)) }}
                                </option>
                            @endforeach
                        </select>

                        <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()"
                               class="border-gray-300 rounded-md shadow-sm text-sm">

                        @if ($status || $date)
                            <a href="{{ route('appointments.index') }}" class="text-sm text-gray-500 self-center hover:underline">
                                Clear filters
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('appointments.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 whitespace-nowrap">
                        + Book Appointment
                    </a>
                </div>

                @if ($appointments->isEmpty())
                    <p class="text-gray-500 text-sm">No appointments found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 uppercase text-xs">
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Time</th>
                                    <th class="px-4 py-2">Customer</th>
                                    <th class="px-4 py-2">Service</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td class="px-4 py-3">{{ $appointment->appointment_date->format('d M Y') }}</td>
                                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('customers.show', $appointment->customer) }}" class="text-indigo-600 hover:underline">
                                                {{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3">{{ $appointment->service->name }}</td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusColors = [
                                                    'pending'   => 'bg-yellow-100 text-yellow-800',
                                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-gray-100 text-gray-600',
                                                    'no_show'   => 'bg-red-100 text-red-800',
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 rounded text-xs {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-600' }}">
                                                {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right space-x-2">
                                            <a href="{{ route('appointments.show', $appointment) }}" class="text-gray-600 hover:underline">View</a>
                                            <a href="{{ route('appointments.edit', $appointment) }}" class="text-gray-600 hover:underline">Edit</a>
                                            <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Delete this appointment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $appointments->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
