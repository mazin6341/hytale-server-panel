<x-layouts.dashboard class="flex flex-col gap-4" title="Users - Hytale Web Panel">
    <div class="w-full flex gap-4 p-2">
        <h3 class="text-xl flex-1">Users</h3>
        <x-button
            sm
            outline
            green
            icon="plus"
            label="Create User"
            onclick="Livewire.dispatch('openModal', { component: 'admin.users.user-modal' })"
        />
    </div>

    <div class="pt-6">
        <livewire:admin.users.user-list />
    </div>
</x-layouts.dashboard>