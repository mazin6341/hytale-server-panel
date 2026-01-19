<div class="p-6 flex flex-col gap-4">
    <div class="font-bold text-xl border-b pb-4 dark:border-gray-800 border-gray-400">
        <h3>{{ isset($user['id']) && $user['id'] ? 'Edit User' : 'Create User'}}</h3>
    </div>

    <x-input
        label="Name"
        placeholder="Name"
        wire:model="user.name"
    />
    <x-input
        label="Email"
        placeholder="Email"
        wire:model="user.email"
    />
    <x-input
        type="password"
        label="Password"
        placeholder="••••••••"
        wire:model="user.password"
    />
    <x-input
        type="password"
        label="Re-type Password"
        placeholder="••••••••"
        wire:model="passwordConfirm"
    />

    <div class="flex gap-4 pt-4">
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
