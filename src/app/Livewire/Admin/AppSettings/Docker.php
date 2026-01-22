<?php

namespace App\Livewire\Admin\AppSettings;

use App\Models\AppSetting;
use Livewire\Component;

class Docker extends Component
{
    #region Variables
    public $settings;
    #endregion

    public function mount() {
        $this->settings = AppSetting::where('section', 'Docker Settings')->get()->map(fn($setting) => ['name' => $setting->name, 'detail' => $setting->detail, 'value' => $setting->getValue(), 'is_encrypted' => $setting->is_encrypted, 'is_boolean' => $setting->is_boolean])->toArray();
    }

    public function render() {
        return view('livewire.admin.app-settings.docker');
    }
}
