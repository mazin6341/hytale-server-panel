<?php

namespace App\Livewire\Admin\AppSettings;

use App\Models\AppSetting;
use App\Services\CurseforgeService;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class ModManagement extends Component
{
    use WireUiActions;

    #region Variables & Rules
    public $mod_manager;
    public $selected_mod_manager;
    public $cf_api;
    public $cf_api_key;

    protected CurseforgeService $curseforge;

    protected $rules = [
        'selected_mod_manager' => 'required',
    ];
    #endregion

    public function boot() {
        $this->curseforge = new CurseforgeService();
    }

    public function mount() {
        // Mod Manager
        $this->mod_manager = AppSetting::where('section', 'Mod Management')->where('name', 'Mod Manager')->first();
        $this->selected_mod_manager = $this->mod_manager->getValue();

        // CF API Key
        $this->cf_api = AppSetting::where('section', 'Mod Management')->where('name', 'CurseForge API Key')->first();
        $this->cf_api_key = $this->cf_api->getValue();
    }

    public function save() {
        $this->validate();

        try {
            $this->mod_manager->update(['value' => $this->selected_mod_manager]);
    
            if($this->selected_mod_manager == 'CurseForge') {
                $this->cf_api->update(['value' => encrypt($this->cf_api_key)]);

                $url = AppSetting::where('section', 'Hidden')->where('name', 'CurseForge API URL')->first()?->getValue() ?? 'https://api.curseforge.com';

                if (!empty($this->cf_api_key) && $this->curseforge->confirmAccess($this->cf_api_key, $url)) {
                    $this->notification()->success('Mod Management Settings Saved!', 'Your CurseForge API Key is working correctly.');
                } else {
                    $fallbackApiKey = AppSetting::where('section', 'Hidden')->where('name', 'CurseForge API Key')->first()?->getValue();

                    if ($fallbackApiKey && $this->curseforge->confirmAccess($fallbackApiKey, $url)) {
                        $this->notification()->warning(
                            'Settings Saved, but with a warning.',
                            'Your provided API key did not work. The system will use the default fallback key.'
                        );
                    } else {
                        $this->notification()->error(
                            'Critical API Error',
                            'Neither your API key nor the fallback key are working. Please obtain a valid CurseForge API key or switch to Manual mod management.'
                        );
                    }
                }
            } else {
                $this->notification()->success('Mod Management Settings Saved!');
            }
        } catch (\Throwable $th) {
            $this->notification()->error('Error saving Mod Management Settings', $th->getMessage());
        }
    }

    public function render() {
        return view('livewire.admin.app-settings.mod-management');
    }
}
