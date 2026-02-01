<?php

namespace App\Livewire\Admin\AppSettings;

use App\Models\AppSetting;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class WebMap extends Component
{
    use WireUiActions;

    #region Variables & Rules
    public $settings;

    protected $rules = [
        'settings' => 'required',
    ];
    #endregion
    
    public function mount() {
        $this->settings = AppSetting::where('section', 'Web Map')->get()->map(fn($setting) => ['name' => $setting->name, 'detail' => $setting->detail, 'value' => $setting->getValue(), 'type' => $setting->type])->toArray();
    }

    public function save() {
        // Find URL setting and prepend protocol if missing
        foreach ($this->settings as &$setting) {
            if ($setting['name'] === 'URL' && !empty($setting['value'])) {
                if (!Str::startsWith($setting['value'], ['http://', 'https://'])) {
                    $setting['value'] = 'http://' . $setting['value'];
                }
                break;
            }
        }
        unset($setting);

        $config = collect($this->settings)->pluck('value', 'name');
        $url = $config->get('URL');
        $port = $config->get('Port');
        $enabled = filter_var($config->get('Enable Map'), FILTER_VALIDATE_BOOLEAN);

        // Prevent Calls to Self
        $parsedHost = parse_url($url, PHP_URL_HOST);

        // Prevent Calls to Cloud Metadata
        if ($parsedHost === '169.254.169.254') {
            $this->notification()->error('Invalid URL', 'Restricted IP address.');
            return;
        }

        // Prevent Calls to Self (Localhost on same port)
        if (in_array($parsedHost, ['localhost', '127.0.0.1', '::1']) && $port == request()->server('SERVER_PORT')) {
            $this->notification()->error('Invalid URL', 'Cannot connect to the panel itself.');
            return;
        }

        // Validate
        if ($enabled) {
            $fullUrl = "{$url}:{$port}/api/worlds";

            try {
                $client = new Client(['timeout' => 3]);
                $response = $client->get($fullUrl);

                if ($response->getStatusCode() !== 200) {
                    $this->notification()->error('Connection Failed', 'API returned status: ' . $response->getStatusCode());
                    return;
                }
            } catch (\GuzzleHttp\Exception\ConnectException $e) {
                $this->notification()->error('Connection Failed', 'Unable to connect to the server. Please check the URL and Port.');
                return;
            } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                $this->notification()->error('Connection Failed', 'API returned status: ' . $e->getResponse()->getStatusCode());
                return;
            } catch (\Exception $e) {
                $this->notification()->error('Connection Failed', 'An error occurred while communicating with the Web Map API.');
                return;
            }
        }

        foreach ($this->settings as $setting) {
            AppSetting::where('section', 'Web Map')->where('name', $setting['name'])->update(['value' => $setting['value']]);
        }

        $this->notification()->success('Success', 'Settings saved successfully.');
    }
    
    public function render() {
        return view('livewire.admin.app-settings.web-map');
    }
}
