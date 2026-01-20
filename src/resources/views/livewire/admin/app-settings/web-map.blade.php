<div class="max-w-4xl mx-auto p-4 sm:p-6 space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-100">
                Web Map Configuration
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Manage your Web Map settings.
            </p>
        </div>
        <x-button 
            primary 
            label="Save Changes" 
            wire:click="save" 
            spinner="save" 
            class="w-full sm:w-auto"
        />
    </div>

    <x-card shadow="none" class="border border-gray-200 dark:border-secondary-700 bg-white dark:bg-secondary-800">
        <div class="divide-y divide-gray-100 dark:divide-secondary-700">
            @foreach($settings as $i => $setting)
                <div class="py-5 first:pt-0 last:pb-0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 items-center gap-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                {{ $setting['name'] }}
                            </span>
                            @if($setting['detail'] != null)
                                <p class="text-2xs dark:text-gray-400">{{ $setting['detail'] }}</p>
                            @endif
                            @if($setting['is_encrypted'])
                                <div class="flex items-center gap-1.5 mt-1">
                                    <x-icon name="lock-closed" class="w-3.5 h-3.5 text-blue-500" />
                                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                        Encrypted
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="flex sm:justify-end">
                            @if($setting['is_boolean'])
                                <x-toggle 
                                    wire:model="settings.{{$i}}.value" 
                                    lg 
                                />
                            @else
                                <div class="w-full sm:max-w-xs">
                                    <x-input 
                                        wire:model="settings.{{$i}}.value"
                                        placeholder="Value for {{ $setting['name'] }}"
                                        type="{{ $setting['is_encrypted'] ? 'password' : 'text' }}"
                                        class="dark:bg-secondary-900 dark:border-secondary-600 dark:text-gray-300"
                                    />
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </x-card>
</div>