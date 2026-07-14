<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Services') }}
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
                    <form method="GET" action="{{ route('services.index') }}" class="flex-1 max-w-sm">
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search services..."
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        >
                    </form>

                    <a href="{{ route('services.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 whitespace-nowrap">
                        + Add Service
                    </a>
                </div>

                @if ($services->isEmpty())
                    <p class="text-gray-500 text-sm">No services yet — add your first one.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 uppercase text-xs">
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Duration</th>
                                    <th class="px-4 py-2">Price</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($services as $service)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('services.show', $service) }}" class="text-indigo-600 hover:underline">
                                                {{ $service->name }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3">{{ $service->duration }} min</td>
                                        <td class="px-4 py-3">R{{ number_format($service->price, 2) }}</td>
                                        <td class="px-4 py-3">
                                            @if ($service->active)
                                                <span class="text-green-700 bg-green-100 px-2 py-1 rounded text-xs">Active</span>
                                            @else
                                                <span class="text-gray-600 bg-gray-100 px-2 py-1 rounded text-xs">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right space-x-2">
                                            <a href="{{ route('services.edit', $service) }}" class="text-gray-600 hover:underline">Edit</a>
                                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Delete this service?');">
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
                        {{ $services->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
