<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers') }}
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
                    <form method="GET" action="{{ route('customers.index') }}" class="flex-1 max-w-sm">
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search by name, phone, or email..."
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        >
                    </form>

                    <a href="{{ route('customers.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 whitespace-nowrap">
                        + Add Customer
                    </a>
                </div>

                @if ($customers->isEmpty())
                    <p class="text-gray-500 text-sm">No customers yet — add your first one.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 uppercase text-xs">
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Phone</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('customers.show', $customer) }}" class="text-indigo-600 hover:underline">
                                                {{ $customer->first_name }} {{ $customer->last_name }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3">{{ $customer->phone }}</td>
                                        <td class="px-4 py-3">{{ $customer->email ?? '—' }}</td>
                                        <td class="px-4 py-3 text-right space-x-2">
                                            <a href="{{ route('customers.edit', $customer) }}" class="text-gray-600 hover:underline">Edit</a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Delete this customer?');">
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
                        {{ $customers->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
