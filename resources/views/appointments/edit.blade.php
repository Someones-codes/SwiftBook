<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="customer_id" value="Customer" />
                        <select id="customer_id" name="customer_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                        {{ old('customer_id', $appointment->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->first_name }} {{ $customer->last_name }} — {{ $customer->phone }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="service_id" value="Service" />
                        <select id="service_id" name="service_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                        data-duration="{{ $service->duration }}"
                                        {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} ({{ $service->duration }} min — R{{ number_format($service->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
                        <p id="service-duration-hint" class="mt-1 text-xs text-gray-500"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="appointment_date" value="Date" />
                            <x-text-input id="appointment_date" name="appointment_date" type="date" class="mt-1 block w-full"
                                          value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" required />
                            <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="appointment_time" value="Time" />
                            <x-text-input id="appointment_time" name="appointment_time" type="time" class="mt-1 block w-full"
                                          value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" required />
                            <x-input-error :messages="$errors->get('appointment_time')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach (\App\Models\Appointment::STATUSES as $statusOption)
                                <option value="{{ $statusOption }}" {{ old('status', $appointment->status) === $statusOption ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $statusOption)) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="notes" value="Notes" />
                        <textarea id="notes" name="notes" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $appointment->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Update Appointment</x-primary-button>
                        <a href="{{ route('appointments.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        const serviceSelect = document.getElementById('service_id');
        const hint = document.getElementById('service-duration-hint');

        function updateHint() {
            const selected = serviceSelect.options[serviceSelect.selectedIndex];
            const duration = selected?.dataset?.duration;
            hint.textContent = duration ? `Duration: ${duration} minutes` : '';
        }

        serviceSelect.addEventListener('change', updateHint);
        updateHint();
    </script>
</x-app-layout>
