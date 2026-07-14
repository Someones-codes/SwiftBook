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

            {{-- Appointment history — populated once Milestone 5 is built --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Appointment History</h3>
                <p class="text-sm text-gray-500">No appointment history yet — this fills in once the Appointment module (Milestone 5) is built.</p>
            </div>

        </div>
    </div>
</x-app-layout>
