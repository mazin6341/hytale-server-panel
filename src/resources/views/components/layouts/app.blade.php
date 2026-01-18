<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        @wireUiScripts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased dark:bg-gradient-to-bl dark:from-gray-950 dark:to-gray-900 dark:text-gray-100 bg-gradient-to-bl from-gray-50 to-gray-100 text-gray-900">
        {{ $slot }}
        @livewireScripts
    </body>
</html>