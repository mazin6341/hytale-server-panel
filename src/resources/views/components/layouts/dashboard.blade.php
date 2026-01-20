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
        <div x-data="{ mobileMenuOpen: false }" class="flex h-screen overflow-hidden dark:bg-linear-to-bl dark:from-gray-950 dark:to-gray-900 dark:text-gray-100 bg-linear-to-bl from-gray-50 to-gray-100 text-gray-900"> 
            <div x-show="mobileMenuOpen" class="fixed inset-0 z-50 flex md:hidden" x-cloak>
                <div x-show="mobileMenuOpen" 
                        x-transition:enter="transition-opacity ease-linear duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-linear duration-300"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="mobileMenuOpen = false"></div>

                <div x-show="mobileMenuOpen" 
                        x-transition:enter="transition ease-in-out duration-300 transform"
                        x-transition:enter-start="-translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transition ease-in-out duration-300 transform"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="-translate-x-full"
                        class="relative flex flex-col w-full max-w-xs bg-white dark:bg-slate-900 shadow-xl">
                    <div class="absolute top-0 right-0 -mr-12 pt-4">
                        <button @click="mobileMenuOpen = false" class="text-white focus:outline-none">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <x-layouts.sidebar />
                </div>
            </div>

            <div class="hidden md:flex md:shrink-0">
                <x-layouts.sidebar />
            </div>

            <div class="flex flex-col flex-1 w-0 overflow-hidden">
                <header class="md:hidden flex items-center justify-between px-4 py-3 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
                    <span class="text-gray-500 font-bold">Hytale Web Panel</span>
                    <button @click="mobileMenuOpen = true" class="p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-lg">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </header>

                <main class="flex-1 overflow-y-auto focus:outline-none p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewire('wire-elements-modal')
        @livewireScripts
    </body>
</html>
