<div class="p-4 space-y-8">
    @can('view server mods')
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex-1">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Server Mods</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage your mod library. Install directly from CurseForge or sync manual uploads.</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center px-4 py-2 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400 text-xs font-medium border border-yellow-100 dark:border-yellow-700/30">
                    <x-icon name="exclamation-circle" class="w-4 h-4 mr-2" />
                    <span>Restart required to apply changes</span>
                </div>
                @can('manage server mods')
                    <x-button 
                        secondary 
                        label="Sync Files" 
                        icon="arrow-path" 
                        wire:click="syncLocalMods" 
                        wire:loading.attr="disabled"
                        class="shadow-sm hover:shadow-md transition-shadow"
                    />
                @else
                    <button disabled class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-400 bg-gray-50 dark:bg-gray-800 cursor-not-allowed opacity-75">
                        <x-icon name="lock-closed" class="w-4 h-4 mr-2" />
                        Sync Files
                    </button>
                @endcan
            </div>
        </div>

        {{-- Tabs & Main Content --}}
        <div x-data="{ openTab: '{{ auth()->user()->can('manage server mods') ? 'searchMods' : 'installedMods' }}' }" class="flex flex-col gap-6">
            {{-- Tab Navigation --}}
            <div class="flex p-1 space-x-1 bg-gray-100 dark:bg-gray-800 rounded-xl w-fit">
                @can('manage server mods')
                    <button 
                        @click="openTab = 'searchMods'"
                        :class="openTab === 'searchMods' ? 'bg-white dark:bg-gray-700 shadow text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200"
                    >
                        <x-icon name="magnifying-glass" class="w-4 h-4 mr-2" />
                        Browse
                    </button>
                @endcan

                <button 
                    @click="openTab = 'installedMods'"
                    :class="openTab === 'installedMods' ? 'bg-white dark:bg-gray-700 shadow text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200"
                >
                    <x-icon name="archive-box" class="w-4 h-4 mr-2" />
                    Library
                    <span class="ml-2 bg-gray-200 dark:bg-gray-600 text-xs py-0.5 px-2 rounded-full">
                        {{ count($this->installedMods) }}
                    </span>
                </button>
            </div>

            @can('manage server mods')
                <div x-show="openTab === 'searchMods'" class="animate-fade-in">
                    <div class="relative mb-6">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-icon name="magnifying-glass" class="h-5 w-5 text-gray-400" />
                        </div>
                        <input 
                            type="text" 
                            wire:model.live.debounce.500ms="searchQuery"
                            class="block w-full pl-10 pr-4 py-3 border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent shadow-sm transition-shadow"
                            placeholder="Search CurseForge..."
                        >
                        <div class="absolute inset-y-0 right-2 flex items-center">
                            <x-button primary sm label="Search" wire:click="searchForMod" />
                        </div>
                    </div>

                    <div wire:loading wire:target="searchQuery, searchForMod, nextPage, previousPage" class="w-full py-12">
                        <div class="flex flex-col items-center justify-center">
                            <x-icon name="arrow-path" class="w-10 h-10 animate-spin text-primary-500 mb-4" />
                            <p class="text-gray-500 font-medium">Searching CurseForge...</p>
                        </div>
                    </div>

                    <div wire:loading.remove wire:target="searchQuery, searchForMod, nextPage, previousPage">
                        @if(count($searchedMods) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                @foreach($searchedMods as $mod)
                                    <div class="flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 h-full">
                                        <div class="p-5 flex gap-4 items-start">
                                            <div class="shrink-0">
                                                <img class="h-16 w-16 rounded-xl object-cover bg-gray-100 dark:bg-gray-700 shadow-sm" src="{{ $mod['logo']['thumbnailUrl'] ?? '' }}" alt="{{ $mod['name'] }}" loading="lazy">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight break-words">{{ $mod['name'] }}</h3>
                                                <p class="text-xs text-primary-600 dark:text-primary-400 font-medium mt-1">by {{ $mod['authors'][0]['name'] ?? 'Unknown Author' }}</p>
                                            </div>
                                        </div>

                                        <div class="px-5 pb-4 flex-grow">
                                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 leading-relaxed">{{ $mod['summary'] ?? 'No description available.' }}</p>
                                        </div>

                                        <div class="px-5 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700/50 mt-auto rounded-b-2xl">
                                            <div class="flex items-center justify-between">
                                                <div class="flex flex-col gap-1.5">
                                                    <div class="flex items-center gap-3 text-xs font-semibold text-gray-600 dark:text-gray-300">
                                                        <div class="flex items-center gap-1.5" title="Total Downloads">
                                                            <x-icon name="arrow-down-tray" class="w-3.5 h-3.5 text-gray-400" />
                                                            <span>{{ number_format($mod['downloadCount'] ?? 0) }}</span>
                                                        </div>
                                                        <span class="text-gray-300 dark:text-gray-600">|</span>
                                                        <div class="flex items-center gap-1.5" title="File Size">
                                                            <x-icon name="document" class="w-3.5 h-3.5 text-gray-400" />
                                                            <span>{{ $this->formatBytes($mod['latestFiles'][0]['fileLength'] ?? 0) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-[10px] text-gray-400 font-medium pl-0.5">Updated {{ \Carbon\Carbon::parse($mod['dateModified'])->diffForHumans(null, true) }} ago</div>
                                                </div>

                                                <div class="flex items-center gap-2 pl-2">
                                                    @if($mod['is_installed'])
                                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-green-100 text-green-800 text-xs font-bold dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800/50">
                                                            <x-icon name="check" class="w-3.5 h-3.5 mr-1.5" /> Installed
                                                        </span>
                                                    @else
                                                        <button wire:click="installMod({{ $mod['id'] }})" class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-bold rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all active:scale-95">
                                                            <x-icon name="plus" class="w-3.5 h-3.5 mr-1.5" /> Install
                                                        </button>
                                                    @endif
                                                    
                                                    @if(isset($mod['links']['websiteUrl']))
                                                        <a href="{{ $mod['links']['websiteUrl'] }}" target="_blank" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors" title="View on CurseForge">
                                                            <x-icon name="arrow-top-right-on-square" class="w-4 h-4" />
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Pagination --}}
                            <div class="flex justify-center mt-8">
                                <div class="inline-flex items-center bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-1">
                                    <button wire:click="previousPage" @if($currentPage == 1) disabled @endif class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50 transition-colors">
                                        <x-icon name="chevron-left" class="w-5 h-5" />
                                    </button>
                                    <span class="px-4 text-sm font-medium text-gray-700 dark:text-gray-200">Page {{ $currentPage }}</span>
                                    <button wire:click="nextPage" @if(!$this->canLoadMore) disabled @endif class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50 transition-colors">
                                        <x-icon name="chevron-right" class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-20 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                                <x-icon name="magnifying-glass" class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">No mods found</h3>
                                <p class="text-gray-500">Try adjusting your search terms.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endcan

            <div x-show="openTab === 'installedMods'" class="animate-fade-in" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($this->installedMods as $mod)
                        <div class="flex flex-col bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 h-full group">
                            <div class="p-5 flex gap-4 items-start">
                                <div class="shrink-0 relative">
                                    @if($mod['thumbnail_url'])
                                        <img src="{{ $mod['thumbnail_url'] }}" class="w-16 h-16 rounded-xl object-cover bg-gray-100 dark:bg-gray-700 shadow-sm" loading="lazy">
                                    @else
                                        <div class="w-16 h-16 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                                            <x-icon name="cube" class="w-8 h-8" />
                                        </div>
                                    @endif

                                    @if(!$mod['curse_id'])
                                        <div class="absolute -top-2 -right-2 bg-orange-100 text-orange-600 dark:bg-orange-900 dark:text-orange-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-orange-200 dark:border-orange-800 shadow-sm">
                                            LOCAL
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight break-words">{{ $mod['name'] }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-1">Version: {{ $mod['version'] ?? 'Unknown' }}</p>
                                </div>
                            </div>

                            <div class="px-5 pb-4 flex-grow">
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 leading-relaxed">{{ $mod['summary'] ?? $mod['file_name'] }}</p>
                            </div>

                            <div class="px-5 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700/50 mt-auto rounded-b-2xl">
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center gap-3 text-xs font-semibold text-gray-600 dark:text-gray-300">
                                            @if(isset($mod['size']))
                                                <div class="flex items-center gap-1.5" title="File Size">
                                                    <x-icon name="document" class="w-3.5 h-3.5 text-gray-400" />
                                                    <span>{{ $this->formatBytes($mod['size']) }}</span>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-1.5" title="Filename">
                                                    <x-icon name="document" class="w-3.5 h-3.5 text-gray-400" />
                                                    <span class="truncate max-w-[80px]">File</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-[10px] text-gray-400 font-medium pl-0.5 truncate max-w-[120px]" title="{{ $mod['file_name'] }}">
                                            {{ $mod['file_name'] }}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 pl-2">
                                        @can('manage server mods')
                                            <button 
                                                wire:click="deleteMod({{ $mod['id'] }})"
                                                wire:confirm="Are you sure you want to uninstall {{ $mod['name'] }}?"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-bold rounded-lg shadow-sm text-red-700 bg-red-100 hover:bg-red-200 dark:text-red-400 dark:bg-red-900/30 dark:hover:bg-red-900/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all active:scale-95"
                                            >
                                                <x-icon name="trash" class="w-3.5 h-3.5 mr-1.5" /> Uninstall
                                            </button>
                                        @else
                                            <button disabled class="inline-flex items-center px-4 py-2 border border-gray-200 dark:border-gray-600 text-xs font-bold rounded-lg shadow-sm text-gray-400 bg-gray-100 dark:bg-gray-800 cursor-not-allowed opacity-70">
                                                <x-icon name="lock-closed" class="w-3.5 h-3.5 mr-1.5" /> Uninstall
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                                <x-icon name="inbox" class="w-8 h-8 text-gray-400" />
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Library Empty</h3>
                            <p class="text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto mb-6">No mods installed yet.</p>
                            @can('manage server mods')
                                <x-button primary label="Browse Mods" @click="openTab = 'searchMods'" />
                            @endcan
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="rounded-full bg-red-100 dark:bg-red-900/20 p-6 mb-6">
                <x-icon name="shield-exclamation" class="w-12 h-12 text-red-600 dark:text-red-400" />
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Restricted Access</h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-md">
                You do not have permission to view the server mods configuration. Please contact your administrator if you believe this is an error.
            </p>
        </div>
    @endcan
</div>