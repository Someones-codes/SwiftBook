<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $service->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="divide-y divide-gray-100 text-sm">
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Duration</dt>
                        <dd>{{ $service->duration }} minutes</dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Price</dt>
                        <dd>R{{ number_format($service->price, 2) }}</dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="text-gray-500">Status</dt>
                        <dd>{{ $service->active ? 'Active' : 'Inactive' }}</dd>
                    </div>
                    <div class="py-2">
                        <dt class="text-gray-500 mb-1">Description</dt>
                        <dd>{{ $service->description ?? '—' }}</dd>
                    </div>
                </dl>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('services.edit', $service) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Edit
                    </a>
                    <a href="{{ route('services.index') }}" class="text-sm text-gray-600 hover:underline self-center">
                        Back to Services
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
