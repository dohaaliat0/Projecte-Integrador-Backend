<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ConectaSalud') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js' , 'resources/js/index.js','resources/css/DarAltaBaja.css','resources/css/header.css'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <header>
                <div class="header-container">
                    <h1 class="header-title">
                        {{ config('app.name', 'ConectaSalud') }}
                    </h1>
                    @include('layouts.navigation')
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}

            </main>
        </div>
        @livewireScripts
    </body>
</html>
