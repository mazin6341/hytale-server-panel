<div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
        <thead class="bg-gray-50 dark:bg-slate-800 text-xs uppercase tracking-wider text-gray-700 dark:text-gray-300">
            <tr>
                <th scope="col" class="px-6 py-4 font-semibold">Name</th>
                <th scope="col" class="px-6 py-4 font-semibold">Email</th>
                <th scope="col" class="px-6 py-4 font-semibold text-right">Actions</th>
            </tr>
        </thead>
        
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-slate-900">
            @foreach($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                        {{ $user->name }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="flex justify-end gap-x-2">
                            <x-button 
                                sm
                                flat
                                blue
                                icon="pencil"
                                label="Edit"
                                onclick="Livewire.dispatch('openModal', { component: 'admin.users.user-modal', arguments: { id: {{ $user->id }} }})"
                            />
                            <x-button 
                                sm
                                flat
                                negative
                                icon="trash"
                                wire:click="deleteUser({{$user->id}})"
                                wire:confirm="Are you sure you want to delete this user?"
                                :disabled="Auth::user()->id == $user->id"
                            />
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>