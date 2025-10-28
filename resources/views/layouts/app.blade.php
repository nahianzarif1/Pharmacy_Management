<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pharmacy Management') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Theme Styles -->
        <style>
            :root { --theme: #2fcac1; --theme-dark: #27b3ab; }
            .theme-text { color: var(--theme); }
            .theme-bg { background-color: var(--theme); }
            .theme-border { border-color: var(--theme); }
            .btn-underline { position: relative; }
            .btn-underline::after { content: ""; position: absolute; left: 0; right: 0; bottom: -2px; height: 2px; background: var(--theme); transform: scaleX(0); transform-origin: left; transition: transform 200ms ease; }
            .btn-underline:hover::after { transform: scaleX(1); }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if(isset($header))
                <header class="bg-white/80 backdrop-blur shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @elseif (trim($__env->yieldContent('header')))
                <header class="bg-white/80 backdrop-blur shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @if (isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
    </body>
</html>
