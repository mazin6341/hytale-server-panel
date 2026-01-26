<div class="p-6 transition-colors duration-300">
    <div class="flex flex-col lg:flex-row gap-6">
        
        <div class="w-full lg:w-2/3 flex flex-col gap-4">
            <div class="flex items-center gap-2 mb-1">
                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-gray-400 font-mono">Server Output</h2>
                <div class="h-px flex-1 bg-slate-200 dark:bg-gray-800"></div>
            </div>
            <livewire:admin.dashboard.terminal />
        </div>

        <div class="w-full lg:w-1/3 flex flex-col gap-6">
            
            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-bold font-mono text-slate-500 dark:text-gray-400 uppercase tracking-widest">Power Actions</span>
                    
                    @if($isRunning)
                        <span class="flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-500/10 text-[10px] font-bold text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            RUNNING
                        </span>
                    @else
                        <span class="flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-slate-100 dark:bg-gray-800 text-[10px] font-bold text-slate-500 dark:text-gray-500 border border-slate-200 dark:border-gray-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            OFFLINE
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3">
                    @if(!$isRunning)
                        <x-button 
                            green
                            xl
                            label="Start Server"
                            icon="play"
                            wire:click="start" 
                            spinner="start" 
                            class="font-bold shadow-sm"
                            :disabled="!\Auth::user()->can('manage docker container')"
                        />
                    @else
                        <div class="flex flex-col sm:flex-row lg:flex-col gap-3">
                            <x-button 
                                red 
                                outline
                                label="Stop"
                                icon="stop"
                                wire:click="stop" 
                                spinner="stop" 
                                class="flex-1 font-bold"
                                :disabled="!\Auth::user()->can('manage docker container')"
                            />
                            <x-button 
                                blue 
                                label="Restart"
                                icon="arrow-path"
                                wire:click="restart" 
                                spinner="restart" 
                                class="flex-1 font-bold shadow-sm"
                                :disabled="!\Auth::user()->can('manage docker container')"
                            />
                        </div>
                    @endif
                </div>

                @if(!\Auth::user()->can('manage docker container'))
                    <p class="text-[10px] text-center text-slate-400 dark:text-gray-600 font-mono mt-3 italic">
                        Insufficient permissions.
                    </p>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-1 bg-amber-50 dark:bg-amber-500/10 rounded">
                        <svg class="w-3 h-3 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold font-mono text-slate-500 dark:text-gray-400 uppercase tracking-widest">Maintenance</span>
                </div>

                <div class="flex flex-col gap-3">
                    <x-button 
                        secondary 
                        outline
                        label="Check & Download Updates" 
                        icon="cloud-arrow-down" 
                        wire:click="runUpdate"
                        spinner="runUpdate"
                        class="w-full text-xs font-bold"
                        :disabled="!\Auth::user()->can('manage docker container')"
                    />
                    @can('view docker logs')
                        <x-button 
                            secondary 
                            outline
                            label="Export Server Logs" 
                            icon="document-arrow-down" 
                            wire:click="exportLogs"
                            spinner="exportLogs"
                            class="w-full text-xs font-bold"
                        />
                    @endcan
                </div>
                
                <p class="text-2xs text-slate-400 dark:text-gray-600 font-mono mt-3 leading-tight">
                    <span class="text-amber-500">Note:</span> Updating will download files to the persistent volume. Restarting is required to apply changes to the game server.
                </p>

                @if(!\Auth::user()->can('manage docker container'))
                    <p class="text-[10px] text-center text-slate-400 dark:text-gray-600 font-mono mt-3 italic">
                        Insufficient permissions.
                    </p>
                @endif
            </div>

            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2 mb-1 px-1">
                    <span class="text-[10px] font-bold font-mono text-slate-500 dark:text-gray-400 uppercase tracking-widest">Live Metrics</span>
                    <div class="h-px flex-1 bg-slate-200 dark:bg-gray-800 opacity-50"></div>
                </div>
                <livewire:admin.dashboard.statistics />
            </div>
        </div>
    </div>
</div>