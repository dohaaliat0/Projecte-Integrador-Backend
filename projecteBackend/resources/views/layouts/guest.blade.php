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
        @vite(['resources/css/app.css', 'resources/js/app.js','resources/css/header.css'])
    </head>
    <body>
        <header class="header">
            <div class="header-container">
                <h1 class="header-title">
                    <a href="/dashboard" class="header-link">
                        {{ config('app.name', 'ConectaSalud') }}
                    </a>
                </h1>
            </div>
        </header>
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center ">
            <div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
