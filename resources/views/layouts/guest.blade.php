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
            :root { --theme: #2fcac1; --theme-dark: #27b3ab; --theme-contrast: #0f766e; }
            .theme-text { color: var(--theme); }
            .theme-bg { background-color: var(--theme); }
            .btn-underline { position: relative; }
            .btn-underline::after { content: ""; position: absolute; left: 0; right: 0; bottom: -2px; height: 2px; background: var(--theme); transform: scaleX(0); transform-origin: left; transition: transform 200ms ease; }
            .btn-underline:hover::after { transform: scaleX(1); }
            .btn-theme { background: var(--theme); color: white; }
            .btn-theme:hover { background: var(--theme-dark); }
            .link-theme { color: var(--theme); }
            .link-theme:hover { color: var(--theme-contrast); }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 to-gray-100">
            <div>
                <a href="/" class="flex items-center gap-2 btn-underline">
                    <x-application-logo class="w-20 h-20 fill-current" style="color: var(--theme)" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white/90 backdrop-blur shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
