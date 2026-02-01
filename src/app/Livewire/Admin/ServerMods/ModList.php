<?php

namespace App\Livewire\Admin\ServerMods;

use App\Models\AppSetting;
use Livewire\Component;

class ModList extends Component
{
    #region Variables
    public string $modManager;
    #endregion
    
    public function mount() {
        $this->modManager = AppSetting::where('section', 'Mod Management')->where('name', 'Mod Manager')->first()?->getValue();
    }

    public function render() {
        return view('livewire.admin.server-mods.mod-list');
    }
}