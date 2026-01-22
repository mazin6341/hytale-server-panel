<div class="p-6 flex flex-col gap-4">
    <div class="font-bold text-lg border-b pb-4 dark:border-gray-800 border-gray-400">
        <h3>Manage Permissions for {{ $user->name }}</h3>
    </div>

    <div class="flex flex-col gap-4">
        @foreach($permissions as $i => $permission)
            <x-toggle 
                id="permission-{{ $permission->id }}"
                label="{{ ucwords(strtolower($permission->name)) }}" 
                value="{{$permission->name}}" 
                wire:model="usersPermissions"
            />
        @endforeach
    </div>

    <div class="flex gap-4 pt-4 border-t dark:border-gray-800 border-gray-400">
        <x-button
            outline
            red
            icon="arrow-left"
            label="Cancel"
            wire:click="closeModal"
        />
        <x-button
            outline
            green
            icon="check-circle"
            label="Save"
            wire:click="save"
        />
    </div>
</div>
