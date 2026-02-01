<div class="max-w-4xl mx-auto p-4 sm:p-6 space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-100">
                Mod Management
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Configure how you want to manage server mods.
            </p>
        </div>

        @can('manage mod management')
            <x-button 
                primary 
                label="Save Changes" 
                wire:click="save" 
                spinner="save" 
                class="w-full sm:w-auto"
            />
        @else
            <span class="text-xs font-medium text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                View Only
            </span>
        @endcan
    </div>

    <x-card shadow="none" class="border border-gray-200 dark:border-secondary-700 bg-white dark:bg-secondary-800">
        <div class="divide-y divide-gray-100 dark:divide-secondary-700">
            <div class="py-5 first:pt-0 last:pb-0">
                <div class="grid grid-cols-1 sm:grid-cols-2 items-center gap-4">
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                            {{ $mod_manager->name }}
                        </span>
                        @if($mod_manager->detail != null)
                            <p class="text-2xs dark:text-gray-400">{{ $mod_manager->detail }}</p>
                        @endif
                    </div>

                    <div class="flex sm:justify-end">
                        <x-select
                            wire:model.live="selected_mod_manager"
                            placeholder="Select {{ $mod_manager->name }}"
                            :options="$mod_manager->getDropdown()"
                        />
                    </div>
                </div>
            </div>

            <div class="py-5 first:pt-0 last:pb-0">
                <div class="grid grid-cols-1 sm:grid-cols-2 items-center gap-4">
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                            {{ $cf_api->name }}
                        </span>
                        @if($cf_api->detail != null)
                            <p class="text-2xs dark:text-gray-400">{{ $cf_api->detail }}</p>
                        @endif
                    </div>

                    <div class="flex sm:justify-end">
                        <x-input
                            wire:model="cf_api_key"
                            placeholder="CurseForge API Key"
                            type="password"
                            :disabled="$selected_mod_manager == 'Manual'"
                        />
                    </div>
                </div>
            </div>
        </div>
    </x-card>
</div>