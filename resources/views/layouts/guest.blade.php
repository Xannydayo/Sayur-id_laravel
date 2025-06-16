<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-green-50 to-green-100 dark:from-gray-900 dark:to-gray-800">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-2xl">
                <div class="mb-8 text-center">
                    <a href="/" class="inline-block">
                        <x-application-logo class="w-20 h-20 fill-current text-green-600 dark:text-green-400" />
                    </a>
                    <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                        {{ config('app.name', 'Laravel') }}
                    </h2>
                </div>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
