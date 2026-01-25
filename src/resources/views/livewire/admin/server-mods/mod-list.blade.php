<div x-data="{ compact: false }" class="space-y-6 p-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Server Mods</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Manage and deploy modifications to your game directory.</p>
            <p class="mt-1 text-xs text-secondary-500 dark:text-secondary-400">
                <span class="font-mono text-primary-600 dark:text-primary-400">NOTE:</span> Make sure to restart the game server to apply your mods!
            </p>
        </div>
    </div>

    @can('manage server mods')
    <x-card title="Upload Mods" icon="cloud-arrow-up">
        <div class="flex flex-col gap-4">
            <div class="flex flex-col sm:flex-row gap-4 items-start">
                <div class="grow w-full">
                    <div class="relative">
                        <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-400 mb-1">
                            Select Files
                        </label>
                        
                        <input 
                            type="file" 
                            multiple
                            wire:model="modFiles" 
                            accept=".jar,.zip"
                            class="block w-full text-sm text-secondary-500
                                border border-secondary-300 dark:border-secondary-700 rounded-lg
                                bg-white dark:bg-secondary-800 focus:outline-none cursor-pointer
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-l-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary-50 file:text-primary-700
                                hover:file:bg-primary-100
                                dark:file:bg-secondary-700 dark:file:text-primary-400
                                dark:hover:file:bg-secondary-600 transition-all"
                        />
                        
                        <p class="mt-2 text-xs text-secondary-500 dark:text-secondary-400">
                            Supported formats: <span class="font-mono text-primary-600 dark:text-primary-400">.jar, .zip</span>
                        </p>
                    </div>
                </div>

                <div class="sm:mt-6">
                    <x-button 
                        primary 
                        icon="plus" 
                        label="Install" 
                        wire:click="uploadMod" 
                        spinner="uploadMod" 
                        class="w-full sm:w-auto"
                    />
                </div>
            </div>

            @error('modFiles.*') 
                <div class="mt-2 p-3 rounded-lg bg-negative-50 dark:bg-negative-900/20 border border-negative-200 dark:border-negative-800">
                    <div class="flex items-center gap-2 text-sm text-negative-600 dark:text-negative-400">
                        <x-icon name="exclamation-circle" class="w-4 h-4" />
                        <span class="font-semibold">Upload Error</span>
                    </div>
                    <ul class="mt-1 list-disc list-inside text-xs text-negative-500 dark:text-negative-400">
                        @foreach ($errors->get('modFiles.*') as $message)
                            <li>{{ $message[0] }}</li>
                        @endforeach
                    </ul>
                </div>
            @enderror
            
            @error('modFiles')
                <x-badge flat negative label="{{ $message }}" icon="exclamation" class="w-fit" />
            @enderror

            <div wire:loading wire:target="modFiles" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 animate-pulse">
                <x-icon name="arrow-path" class="w-4 h-4 animate-spin" />
                <span>Preparing files...</span>
            </div>
        </div>
    </x-card>
    @endcan

    @can('view server mods')
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <div class="flex items-center gap-2">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">
                    Installed Mods ({{ count($mods) }})
                </h3>
            </div>
            
            <div class="flex items-center gap-1 bg-gray-200/50 dark:bg-secondary-800 p-1 rounded-lg">
                <button @click="compact = false" type="button"
                    :class="!compact ? 'bg-white dark:bg-secondary-700 shadow-sm text-primary-600' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="p-1.5 rounded-md transition-all duration-200">
                    <x-icon name="list-bullet" class="w-4 h-4" />
                </button>
                <button @click="compact = true" type="button"
                    :class="compact ? 'bg-white dark:bg-secondary-700 shadow-sm text-primary-600' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="p-1.5 rounded-md transition-all duration-200">
                    <x-icon name="bars-4" class="w-4 h-4" />
                </button>
            </div>
        </div>

        <div class="bg-white dark:bg-secondary-900 rounded-xl shadow-sm border border-gray-200 dark:border-secondary-700 overflow-hidden">
            
            @if(count($mods) > 0)
                <div :class="compact ? 'px-4 py-2' : 'px-6 py-3'"
                    class="grid grid-cols-12 gap-4 bg-gray-50/50 dark:bg-secondary-800/50 border-b border-gray-200 dark:border-secondary-700 items-center">
                    
                    <div class="col-span-7 sm:col-span-8">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Mod Information</span>
                    </div>
                    <div class="hidden sm:block sm:col-span-2 text-right">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">File Size</span>
                    </div>
                    <div class="col-span-5 sm:col-span-2 text-right">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Actions</span>
                    </div>
                </div>
            @endif

            <ul role="list" class="divide-y divide-gray-100 dark:divide-secondary-800">
                @forelse($mods as $mod)
                    <li :class="compact ? 'px-4 py-2' : 'px-6 py-4'"
                        class="group hover:bg-gray-50 dark:hover:bg-secondary-800/40 transition-all duration-200" 
                        wire:key="{{ $mod['filename'] }}">
                        
                        <div class="grid grid-cols-12 gap-4 items-center">
                            <div class="col-span-7 sm:col-span-8 flex items-center min-w-0 gap-3">
                                <div :class="compact ? 'h-8 w-8 rounded-md' : 'h-10 w-10 rounded-lg'"
                                    class="flex-none bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center transition-all">
                                    <x-icon name="puzzle-piece" :class="compact ? 'h-4 w-4' : 'h-5 w-5'" class="text-indigo-600 dark:text-indigo-400" />
                                </div>

                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ $mod['name'] }}
                                    </p>
                                    <p :class="compact ? 'text-[10px]' : 'text-xs'" class="text-gray-500 dark:text-secondary-400 truncate leading-tight mt-0.5">
                                        <span class="font-mono">{{ $mod['filename'] }}</span> 
                                        <span class="text-gray-400 font-normal">
                                            @if($mod['version']) • v{{ $mod['version'] }} @endif
                                            <span x-show="!compact"> • by {{ $mod['author'] }}</span>
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="hidden sm:block sm:col-span-2 text-right">
                                <x-badge flat x-bind:size="compact ? 'xs' : 'sm'" gray :label="$mod['size']" />
                            </div>

                            <div class="col-span-5 sm:col-span-2 text-right">
                                @can('manage server mods')
                                <x-button 
                                    negative 
                                    x-bind:size="compact ? 'xs' : 'sm'"
                                    icon="trash" 
                                    variant="flat"
                                    wire:click="deleteFile(@js($mod['filename']))"
                                    wire:confirm="Are you sure you want to delete {{ $mod['filename'] }}?"
                                    class="sm:opacity-0 group-hover:opacity-100 transition-opacity"
                                />
                                @endcan
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="p-12 text-center">
                        <x-icon name="archive-box" class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-secondary-600" />
                        <p class="text-gray-500 dark:text-gray-400">No mods found in the directory.</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
    @else
    <div class="w-full flex flex-col items-center justify-center p-12 bg-white dark:bg-secondary-900 rounded-xl shadow-sm border border-gray-200 dark:border-secondary-700">
        <div class="bg-gray-100 dark:bg-secondary-800 p-4 rounded-full mb-4">
            <x-icon name="lock-closed" class="w-8 h-8 text-gray-400 dark:text-gray-500" />
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Access Denied</h3>
        <p class="text-gray-500 dark:text-gray-400 text-center mt-1 max-w-sm">
            You do not have permission to view the server mods configuration.
        </p>
    </div>
    @endcan
</div>