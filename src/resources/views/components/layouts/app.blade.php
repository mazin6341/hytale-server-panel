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
    <body class="font-sans antialiased dark:bg-gradient-to-bl dark:from-slate-950 dark:to-slate-900 dark:text-gray-100 bg-gradient-to-bl from-slate-50 to-slate-100 text-gray-900">
        {{ $slot }}
        @livewireScripts
    </body>
</html>