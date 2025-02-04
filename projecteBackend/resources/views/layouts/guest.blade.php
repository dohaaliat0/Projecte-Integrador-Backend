<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @vite(['resources/css/login.css'])
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="bg-gradient-to-r from-gray-400 to-gray-700 shadow-md">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-white">
                {{ config('app.name', 'telefex') }}
            </h1>
            @if (request()->is('login'))
                <a href="{{ url('/register') }}" class="bg-white text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-200 transition duration-300">
                Register
                </a>
            @else
                <a href="{{ url('/login') }}" class="bg-white text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-200 transition duration-300">
                Login
                </a>
            @endif
            </div>
        </header>
        <div class="min-h-screen flex flex-col sm:justify-center items-center ">
            <div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
