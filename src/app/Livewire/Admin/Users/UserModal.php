<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use Throwable;
use WireUi\Traits\WireUiActions;

class UserModal extends ModalComponent
{
    use WireUiActions;

    #region Variables & Rules
    public array $user;
    public $passwordConfirm;
    
    protected $rules = [
        'user.name'         => 'required',
        'user.email'        => 'required|email',
        'user.password'     => 'nullable',
        'passwordConfirm'   => 'nullable|required_with:user.password|same:user.password',
    ];
    #endregion
    
    public function mount($id = null) {
        if ($id)
            $this->user = User::find($id)->toArray();
        else
            $this->user = [];
    }

    public function save() {
        $this->validate();
        try {
            if(isset($this->user['id']) && $this->user['id']){
                $user = User::find($this->user['id']);
                if(isset($this->user['password']) && $this->user['password'])
                    $this->user['password'] = \Illuminate\Support\Facades\Hash::make($this->user['password']);
    
                $user->fill($this->user);
                $user->save();
            } else {
                $user = new User([
                    'name' => $this->user['name'],
                    'email' => $this->user['email'],
                    'password' => \Illuminate\Support\Facades\Hash::make($this->user['password'])
                ]);
                $user->save();
            }
            $this->notification()->success('User saved successfully!');
        } catch (Throwable $th) {
            $this->notification()->error('Unable to save user!', $th->getMessage());
        } finally {
            $this->dispatch('refresh');
            $this->closeModal();
        }
    }

    public static function modalMaxWidth(): string {
        return '3xl';
    }

    public function render() {
        return view('livewire.admin.users.user-modal');
    }
}
