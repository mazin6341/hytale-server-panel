<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\AppSetting;
use App\Services\DockerService;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class ServerControl extends Component
{
    use WireUiActions;

    #region Variables
    public string $containerName;
    public bool $isRunning;
    #endregion

    #region Constructor
    protected DockerService $docker;

    public function __construct() {
        $this->docker = new DockerService();
    }
    #endregion

    public function mount() {
        $this->containerName = AppSetting::where('section', 'Docker Settings')->where('name', 'Container Name')->first()->getValue();
        $this->isRunning = $this->docker->isRunning();
    }

    #region Control Functions
    public function start() {
        if($this->docker->start()) {
            $this->notification()->success('Container started successfully!');
            $this->isRunning = $this->docker->isRunning();
        }
    }

    public function stop() {
        if($this->docker->stop()) {
            $this->notification()->success('Container stopped successfully!');
            $this->isRunning = $this->docker->isRunning();
        }
    }

    public function restart() {
        if($this->docker->restart()) {
            $this->notification()->success('Container restarted successfully!');
            $this->isRunning = $this->docker->isRunning();
        }
    }
    #endregion

    #region Maintenance Functions
    public function runUpdate() {
        $docker = new DockerService();
        $command = "hytale-downloader > /proc/1/fd/1 2>&1 &";
        $docker->sendCommand($command);
        $this->dispatch('notify', ['message' => 'Update started. Check console for progress.', 'type' => 'info']);
    }

    public function updateAndRestart() {
        // $docker = new DockerService();
        // $this->runUpdate();
        // $this->dispatch('notify', ['message' => 'Update initiated. Server will restart shortly.', 'type' => 'warning']);

    }
    #endregion
    
    public function render() {
        return view('livewire.admin.dashboard.server-control');
    }
}
