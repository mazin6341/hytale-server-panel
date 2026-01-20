<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name', 'Hytale Web Panel') }}</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="csrf_token" value="{{ csrf_token() }}"/>

        <x-notifications />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @wireUiScripts
        @livewireStyles
    </head>
    <body class="font-sans antialiased dark:bg-linear-to-bl dark:from-gray-950 dark:to-gray-900 dark:text-gray-100 bg-linear-to-bl from-gray-50 to-gray-100 text-gray-900">
        {{ $slot }}

        @livewire('wire-elements-modal')
        @livewireScripts
    </body>
</html>