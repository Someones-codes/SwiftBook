<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Appointment — {{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="divide-y divide-gray-100 text-sm">
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Customer</dt>
                        <dd>
                            <a href="{{ route('customers.show', $appointment->customer) }}" class="text-indigo-600 hover:underline">
                                {{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}
                            </a>
                        </dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Service</dt>
                        <dd>{{ $appointment->service->name }} ({{ $appointment->service->duration }} min)</dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Date</dt>
                        <dd>{{ $appointment->appointment_date->format('d M Y') }}</dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Time</dt>
                        <dd>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Status</dt>
                        <dd>{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</dd>
                    </div>
                    <div class="py-2">
                        <dt class="text-gray-500 mb-1">Notes</dt>
                        <dd>{{ $appointment->notes ?? '—' }}</dd>
                    </div>
                </dl>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('appointments.edit', $appointment) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Edit
                    </a>
                    <a href="{{ route('appointments.index') }}" class="text-sm text-gray-600 hover:underline self-center">
                        Back to Appointments
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
