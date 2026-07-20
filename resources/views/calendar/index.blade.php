<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    {{-- FullCalendar via CDN — no npm package needed --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Legend --}}
                <div class="flex flex-wrap gap-4 mb-4 text-xs text-gray-600">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full inline-block" style="background:#f59e0b"></span> Pending</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full inline-block" style="background:#3b82f6"></span> Confirmed</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full inline-block" style="background:#22c55e"></span> Completed</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full inline-block" style="background:#ef4444"></span> No Show</span>
                    <span class="text-gray-400">— Cancelled appointments aren't shown</span>
                </div>

                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                height: 'auto',
                events: '{{ route('calendar.events') }}',
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false,
                },
            });

            calendar.render();
        });
    </script>
</x-app-layout>
