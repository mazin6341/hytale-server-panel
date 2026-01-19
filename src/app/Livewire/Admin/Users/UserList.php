<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    #region Listeners
    protected $listeners = [
        'refresh' => 'render'
    ];
    #endregion

    public function list() {
        return paginateCollection(User::all(['id','name','email']));
    }

    public function deleteUser(int $id) {
        User::find($id)->delete();
    }
    
    public function render() {
        return view('livewire.admin.users.user-list', ['users' => $this->list()]);
    }
}
