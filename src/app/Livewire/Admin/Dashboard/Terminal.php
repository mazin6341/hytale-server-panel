<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\AppSetting;
use App\Services\DockerService;
use Livewire\Component;

class Terminal extends Component
{
    public string $containerName;
    public string $command = '';
    public int $logLines = 100;
    public bool $isRunning = false;
    
    public string $logs = '';
    public array $manualBuffer = []; 

    public function mount() {
        $this->containerName = AppSetting::where('section', 'Docker Settings')
            ->where('name', 'Container Name')
            ->first()
            ?->getValue() ?? 'hytale-server';
        
        $this->getDockerLogs();
    }

    public function getDockerLogs() {
        $docker = new DockerService();
        $raw = $docker->getLogs($this->logLines);
        $this->logs = $this->parseLogs($raw);
        $this->isRunning = $docker->isRunning();
    }

    public function sendCommand() {
        if (empty(trim($this->command))) return;

        $docker = new DockerService();
        
        $this->manualBuffer[] = [
            'cmd' => "{$this->command}",
            'out' => "Processing command...",
            'time' => now()->format('H:i:s')
        ];

        try {
            $rawOutput = $docker->sendCommand($this->command);
            $parsedOutput = $this->parseLogs($rawOutput);
            $this->manualBuffer[count($this->manualBuffer) - 1]['out'] = $parsedOutput;
        } catch (\Exception $e) {
            $this->manualBuffer[count($this->manualBuffer) - 1]['out'] = "[ERROR] The request timed out or the server failed to respond.";
        }

        $this->command = '';
    }

    protected function parseLogs($rawLogs) {
        if (!$rawLogs) return '';

        $headerCheck = substr($rawLogs, 1, 3);
        if ($headerCheck !== "\x00\x00\x00")
            return $rawLogs;

        $output = '';
        $position = 0;
        $len = strlen($rawLogs);

        while ($position < $len) {
            if (($position + 8) > $len) break;
            
            $header = substr($rawLogs, $position, 8);
            $sizeData = substr($header, 4, 4);
            $unpacked = unpack('N', $sizeData);
            $payloadSize = $unpacked[1];

            if ($position + 8 + $payloadSize > $len) {
                $output .= substr($rawLogs, $position + 8);
                break;
            }

            $output .= substr($rawLogs, $position + 8, $payloadSize);
            $position += (8 + $payloadSize);
        }

        return $output ?: $rawLogs;
    }

    public function render() {
        return view('livewire.admin.dashboard.terminal');
    }
}