<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'SwiftBook') }} — Appointment Management, Simplified</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased">

        {{-- Nav --}}
        <header class="border-b border-gray-200 bg-white">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <span class="text-xl font-bold text-gray-900">SwiftBook</span>

                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="text-sm font-semibold text-gray-700 hover:text-gray-900">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm font-semibold text-gray-700 hover:text-gray-900">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-semibold rounded-md hover:bg-gray-700">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        {{-- Hero --}}
        <section class="max-w-6xl mx-auto px-6 py-24 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 tracking-tight">
                Appointments, sorted.
            </h1>
            <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                SwiftBook is a simple booking system for service-based businesses —
                built for photographers, barbers, salons, consultants, and more.
                One system, every business.
            </p>

            <div class="mt-8 flex items-center justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-semibold rounded-md hover:bg-gray-700">
                        Go to Dashboard
                    </a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-semibold rounded-md hover:bg-gray-700">
                            Create Free Account
                        </a>
                    @endif
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-md hover:bg-gray-100">
                        Log In
                    </a>
                @endauth
            </div>
        </section>

        {{-- Features --}}
        <section class="max-w-6xl mx-auto px-6 pb-24">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Manage Customers</h3>
                    <p class="text-sm text-gray-600">Keep every customer's details and history in one searchable place.</p>
                </div>
                <div class="bg-white p-6 rounded-lg border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Book Appointments</h3>
                    <p class="text-sm text-gray-600">Schedule services with automatic double-booking prevention.</p>
                </div>
                <div class="bg-white p-6 rounded-lg border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Track Everything</h3>
                    <p class="text-sm text-gray-600">See today's schedule, upcoming bookings, and reports at a glance.</p>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="border-t border-gray-200 py-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} SwiftBook. Built with Laravel.
        </footer>

    </body>
</html>