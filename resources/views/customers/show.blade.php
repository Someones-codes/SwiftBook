<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $customer->first_name }} {{ $customer->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="divide-y divide-gray-100 text-sm">
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Phone</dt>
                        <dd>{{ $customer->phone }}</dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Email</dt>
                        <dd>{{ $customer->email ?? '—' }}</dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Address</dt>
                        <dd>{{ $customer->address ?? '—' }}</dd>
                    </div>
                    <div class="py-2">
                        <dt class="text-gray-500 mb-1">Notes</dt>
                        <dd>{{ $customer->notes ?? '—' }}</dd>
                    </div>
                </dl>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('customers.edit', $customer) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Edit
                    </a>
                    <a href="{{ route('customers.index') }}" class="text-sm text-gray-600 hover:underline self-center">
                        Back to Customers
                    </a>
                </div>
            </div>

            {{-- Appointment history --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment History</h3>

                @php
                    $appointments = $customer->appointments()->with('service')->orderByDesc('appointment_date')->get();
                @endphp

                @if ($appointments->isEmpty())
                    <p class="text-sm text-gray-500">No appointments yet for this customer.</p>
                @else
                    <ul class="divide-y divide-gray-100 text-sm">
                        @foreach ($appointments as $appointment)
                            <li class="py-2 flex justify-between items-center">
                                <div>
                                    <a href="{{ route('appointments.show', $appointment) }}" class="text-indigo-600 hover:underline">
                                        {{ $appointment->service->name }}
                                    </a>
                                    <span class="text-gray-500">
                                        — {{ $appointment->appointment_date->format('d M Y') }}
                                        at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
