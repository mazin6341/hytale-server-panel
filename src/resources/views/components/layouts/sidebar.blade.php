<div class="flex flex-col w-64 h-full border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
    <div class="flex items-center h-16 flex-shrink-0 px-6 border-b border-gray-200 dark:border-gray-800">
        <span class="text-lg font-bold text-gray-600 dark:text-gray-400">Hytale Web Panel</span>
    </div>

    <div class="flex-1 flex flex-col overflow-y-auto">
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
        </nav>
    </div>

    <div class="p-4 w-full flex gap-4">
        <div class="my-auto">
            <x-avatar label="{{ Auth::user()->getInitials() }}" />
        </div>
        <div class="flex flex-col">
            <span class="">{{ Auth::user()->name }}</span>
            <span class="text-gray-200 text-xs">
                <a href="{{ route('auth.logout') }}" class="hover:underline hover:cursor-pointer">Log Out</a>
            </span>
        </div>
    </div>
</div>