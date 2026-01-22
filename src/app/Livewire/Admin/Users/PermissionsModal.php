<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;
use WireUi\Traits\WireUiActions;

class PermissionsModal extends ModalComponent
{
    use WireUiActions;

    #region Variables
    public $user;
    public $permissions;
    public $usersPermissions = [];
    #endregion

    public function mount(int $id) {
        $this->user = User::find($id);
        $this->permissions = Permission::all();
        $this->usersPermissions = $this->user->permissions->pluck('name')->toArray();
    }
    
    public function save() {
        try {
            $this->user->syncPermissions($this->usersPermissions);
            $this->notification()->success('Permissions saved successfully!');
        } catch (\Throwable $th) {
            $this->notification()->error('Unable to save permissions!', $th->getMessage());
        } finally {
            $this->closeModal();
        }
    }

    public function render() {
        return view('livewire.admin.users.permissions-modal');
    }
}
