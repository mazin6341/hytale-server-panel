<x-layouts.dashboard class="flex flex-col gap-4" title="Users - Hytale Web Panel">
    <div class="w-full flex gap-4 p-4">
        <div class="flex-1">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Users</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Manage users and their permissions.</p>
        </div>
        <x-button
            sm
            outline
            green
            icon="plus"
            label="Create User"
            onclick="Livewire.dispatch('openModal', { component: 'admin.users.user-modal' })"
        />
    </div>

    <div class="pt-6 px-4">
        <livewire:admin.users.user-list />
    </div>
</x-layouts.dashboard>