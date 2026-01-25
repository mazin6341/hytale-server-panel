<div class="flex flex-col w-64 h-full border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900" x-data>
    
    <div class="flex items-center h-16 flex-shrink-0 px-6 border-b border-gray-200 dark:border-gray-800">
        <span class="text-lg font-bold text-gray-600 dark:text-gray-400">Hytale Web Panel</span>
    </div>

    <div class="flex-1 flex flex-col overflow-y-auto custom-scrollbar">
        <nav class="flex-1 px-4 py-6 space-y-8">
            
            @foreach($sections as $section)
                <div class="space-y-3">
                    <h3 class="flex items-center text-xs font-semibold text-gray-400 uppercase tracking-wider px-2">
                        @if(!empty($section['svg']))
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                {!! $section['svg'] !!}
                            </svg>
                        @endif
                        {{ $section['name'] }}
                    </h3>

                    <div class="space-y-1">
                        @if(isset($menus[$section['prefix']]))
                            @foreach($menus[$section['prefix']] as $menu)
                                <a href="{{ route($menu['route']) }}" 
                                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all
                                   {{ Request::routeIs($menu['route']) 
                                   ? 'bg-gray-600 text-white shadow-lg shadow-gray-500/20' 
                                   : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ Request::routeIs($menu['route']) ? 'text-white' : 'text-gray-400 group-hover:text-gray-500' }}" 
                                         fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        {!! $menu['svg'] !!}
                                    </svg>
                                    {{ $menu['name'] }}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="space-y-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-800">
                <h3 class="flex items-center text-xs font-semibold text-gray-400 uppercase tracking-wider px-2">
                    Help & Community
                </h3>

                <div class="space-y-1">
                    <a href="/faq" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white transition-all">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                        FAQs
                    </a>

                    <a href="https://discord.gg/kbEEvqRkaH" target="_blank" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.086 2.157 2.419 0 1.334-.956 2.42-2.157 2.42zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.086 2.157 2.419 0 1.334-.946 2.42-2.157 2.42z"/>
                        </svg>
                        Discord
                    </a>

                    <a href="https://github.com/mazin6341/hytale-server-panel/issues" target="_blank" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white transition-all">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                        Report Issue
                    </a>
                    
                    <button type="button" 
                            onclick="$openModal('supportModal')"
                            class="w-full mt-2 group flex items-center px-3 py-2 text-sm font-medium text-pink-600 dark:text-pink-400 bg-pink-50 dark:bg-pink-900/10 rounded-lg hover:bg-pink-100 dark:hover:bg-pink-900/30 transition-all">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        Support Us
                    </button>
                </div>
            </div>
        </nav>
    </div>

    <div class="p-4 w-full flex gap-4 border-t border-gray-200 dark:border-gray-800">
        <div class="my-auto">
            <x-avatar label="{{ Auth::user()->getInitials() }}" />
        </div>
        <div class="flex flex-col">
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</span>
            <span class="text-gray-400 text-xs">
                <a href="{{ route('auth.logout') }}" class="hover:text-gray-600 dark:hover:text-gray-200 transition-colors cursor-pointer">Log Out</a>
            </span>
        </div>
    </div>
</div>

<x-modal name="supportModal" blur align="center" max-width="4xl" z-index="z-[100]">
    <x-card title="Meet the Team" class="relative z-[100] overflow-visible">
        <div class="mb-8 text-center">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Support the Development</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-lg mx-auto leading-relaxed">
                This project is maintained by a small team.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-2">

            <!-- Maazin's Card -->
            <div class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden h-full">
                <div class="h-28 bg-gradient-to-br from-[#9146FF] to-[#6441a5] relative">
                    <div class="absolute inset-0 opacity-10" 
                            style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 12px 12px;">
                    </div>
                </div>

                <div class="px-6 pb-6 flex-1 flex flex-col items-center text-center -mt-12 relative z-10">
                    <div class="relative mb-4">
                        <img src="https://github.com/Mazin6341.png" 
                                alt="Maazin"
                                class="w-24 h-24 rounded-full border-[5px] border-white dark:border-gray-800 shadow-md object-cover bg-white">
                        
                        <span class="absolute bottom-1 right-1 block h-5 w-5 rounded-full ring-4 ring-white dark:ring-gray-800 bg-green-400" title="Active"></span>
                    </div>

                    <h4 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">Maazin</h4>
                    <span class="mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300 border border-purple-100 dark:border-purple-800">
                        Lead Developer - Web Panel
                    </span>

                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        Full-stack developer and Variety Streamer from Maldives.
                    </p>

                    <div class="mt-5 flex items-center justify-center gap-4">
                        <a href="https://github.com/Mazin6341" target="_blank" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.838.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="https://twitch.tv/maazin" target="_blank" class="text-gray-400 hover:text-[#9146FF] transition-colors">
                            <span class="sr-only">Twitch</span>
                            <svg fill="currentColor" class="w-6 h-6" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M80,32,48,112V416h96v64h64l64-64h80L464,304V32ZM416,288l-64,64H256l-64,64V352H112V80H416Z"/><rect x="320" y="143" width="48" height="129"/><rect x="208" y="143" width="48" height="129"/></svg>
                        </a>
                    </div>

                    <div class="mt-6 w-full">
                        <a href="https://twitch.tv/maazin" target="_blank" 
                                class="relative flex items-center justify-center w-full px-4 py-3 bg-[#9146FF] hover:bg-[#772ce8] text-white rounded-xl transition-all shadow-lg shadow-purple-500/30 hover:scale-[1.02] active:scale-95">
                            <svg fill="currentColor" class="w-5 h-5 mr-2.5 animate-pulse" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M80,32,48,112V416h96v64h64l64-64h80L464,304V32ZM416,288l-64,64H256l-64,64V352H112V80H416Z"/><rect x="320" y="143" width="48" height="129"/><rect x="208" y="143" width="48" height="129"/></svg>

                            <span class="font-bold text-sm leading-none pt-0.5">Support on Twitch</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Daniel's Card -->
            <div class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden h-full">
                <div class="h-28 bg-gradient-to-br from-[#9146FF] to-[#6441a5] relative">
                    <div class="absolute inset-0 opacity-10" 
                            style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 12px 12px;">
                    </div>
                </div>

                <div class="px-6 pb-6 flex-1 flex flex-col items-center text-center -mt-12 relative z-10">
                    <div class="relative mb-4">
                        <img src="https://github.com/deinfreu.png" 
                                alt="deinfreu"
                                class="w-24 h-24 rounded-full border-[5px] border-white dark:border-gray-800 shadow-md object-cover bg-white">
                        
                        <span class="absolute bottom-1 right-1 block h-5 w-5 rounded-full ring-4 ring-white dark:ring-gray-800 bg-green-400" title="Active"></span>
                    </div>

                    <h4 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">deinfreu</h4>
                    <span class="mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300 border border-purple-100 dark:border-purple-800">
                        Lead Developer - Hytale Server Container
                    </span>

                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        Student & Developer from Netherlands.
                    </p>

                    <div class="mt-5 flex items-center justify-center gap-4">
                        <a href="https://github.com/deinfreu" target="_blank" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.838.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>

                    <div class="mt-6 w-full">
                    </div>
                </div>
            </div>

            <!-- moking55's Card -->
            <div class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden h-full">
                <div class="h-28 bg-gradient-to-br from-[#9146FF] to-[#6441a5] relative">
                    <div class="absolute inset-0 opacity-10" 
                            style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 12px 12px;">
                    </div>
                </div>

                <div class="px-6 pb-6 flex-1 flex flex-col items-center text-center -mt-12 relative z-10">
                    <div class="relative mb-4">
                        <img src="https://github.com/moking55.png" 
                                alt="moking55"
                                class="w-24 h-24 rounded-full border-[5px] border-white dark:border-gray-800 shadow-md object-cover bg-white">
                        
                        <span class="absolute bottom-1 right-1 block h-5 w-5 rounded-full ring-4 ring-white dark:ring-gray-800 bg-green-400" title="Active"></span>
                    </div>

                    <h4 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">moking55</h4>
                    <span class="mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300 border border-purple-100 dark:border-purple-800">
                        Developer - Hytale Server Container
                    </span>

                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        I'm a master student at Chiang mai university, Chiang mai
                    </p>

                    <div class="mt-5 flex items-center justify-center gap-4">
                        <a href="https://github.com/moking55" target="_blank" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.838.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>

                    <div class="mt-6 w-full">
                    </div>
                </div>
            </div>

            <!-- moking55's Card -->
            <div class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden h-full">
                <div class="h-28 bg-gradient-to-br from-[#9146FF] to-[#6441a5] relative">
                    <div class="absolute inset-0 opacity-10" 
                            style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 12px 12px;">
                    </div>
                </div>

                <div class="px-6 pb-6 flex-1 flex flex-col items-center text-center -mt-12 relative z-10">
                    <div class="relative mb-4">
                        <img src="https://github.com/joeyaurel.png" 
                                alt="joeyaurel"
                                class="w-24 h-24 rounded-full border-[5px] border-white dark:border-gray-800 shadow-md object-cover bg-white">
                        
                        <span class="absolute bottom-1 right-1 block h-5 w-5 rounded-full ring-4 ring-white dark:ring-gray-800 bg-green-400" title="Active"></span>
                    </div>

                    <h4 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">joeyaurel</h4>
                    <span class="mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300 border border-purple-100 dark:border-purple-800">
                        Developer - Hytale Server Container
                    </span>

                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        -
                    </p>

                    <div class="mt-5 flex items-center justify-center gap-4">
                        <a href="https://github.com/joeyaurel" target="_blank" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.838.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>

                    <div class="mt-6 w-full">
                    </div>
                </div>
            </div>

            <!-- Contribute Card -->
            <div class="flex flex-col items-center justify-center h-full min-h-[300px] p-6 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50 dark:bg-gray-800/30 text-center transition-colors hover:border-gray-300 dark:hover:border-gray-600">
                <div class="h-16 w-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-200">Join the Team</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-xs">
                    Interested in contributing to the project? Check out our GitHub issues.
                </p>
                <a href="https://github.com/mazin6341/hytale-server-panel" target="_blank" class="mt-6 text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors flex items-center">
                    View Repository <span aria-hidden="true" class="ml-1">&rarr;</span>
                </a>
            </div>

        </div>

        <x-slot name="footer">
            <div class="flex justify-end w-full">
                <x-button flat label="Close" x-on:click="close" />
            </div>
        </x-slot>
    </x-card>
</x-modal>