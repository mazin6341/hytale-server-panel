<?php

namespace App\Services;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class DockerService
{
    protected $baseUrl = 'http://localhost/v1.52';
    protected $containerName;
    protected $socketPath = '/var/run/docker.sock';

    public function __construct() {
        $this->containerName = AppSetting::where('section', 'Docker Settings')->where('name', 'Container Name')->first()->getValue();
    }

    protected function authorize() {
        if (!Auth::user() || !Auth::user()->can('manage docker container'))
            return false;
        return true;
    }

    protected function client() {
        return Http::withOptions([
            'curl' => [CURLOPT_UNIX_SOCKET_PATH => $this->socketPath],
        ]);
    }

    public function isRunning(): bool {
        $response = $this->client()->get("{$this->baseUrl}/containers/{$this->containerName}/json");

        if ($response->successful()) 
            return $response->json('State.Running') === true;

        return false;
    }

    public function start() {
        if (!$this->authorize()) return false;
        return $this->client()->post("{$this->baseUrl}/containers/{$this->containerName}/start")->successful();
    }

    public function stop() {
        if (!$this->authorize()) return false;
        return $this->client()->post("{$this->baseUrl}/containers/{$this->containerName}/stop")->successful();
    }

    public function restart() {
        if (!$this->authorize()) return false;
        return $this->client()->post("{$this->baseUrl}/containers/{$this->containerName}/restart")->successful();
    }

    public function getLogs(int $tail = 100) {
        if(Auth::user() && !Auth::user()->can('view docker logs')) return "\x1b[1;31m[SYSTEM ERROR] Access Denied: You do not have permission to view these logs.\x1b[0m";

        $response = $this->client()->get("{$this->baseUrl}/containers/{$this->containerName}/logs", [
            'stdout' => true,
            'stderr' => true,
            'tail'   => $tail,
        ]);

        return $response->body();
    }

    public function getStats() {
        if(Auth::user() && !Auth::user()->can('view docker stats')) return null;
        
        $response = $this->client()->get("{$this->baseUrl}/containers/{$this->containerName}/stats", [
            'stream' => false
        ]);

        return $response->json();
    }

    public function sendCommand(string $command) {
        if (!$this->authorize()) return null;

        // Blacklist dangerous interactive commands that hang the terminal
        $blacklist = ['top', 'htop', 'nano', 'vim', 'less'];
        if (in_array(strtolower(explode(' ', trim($command))[0]), $blacklist)) {
            return "\x1b[1;31m[ERROR] Command '$command' is interactive and cannot be run from this web console.\x1b[0m";
        }

        $execSetup = $this->client()->post("{$this->baseUrl}/containers/{$this->containerName}/exec", [
            'AttachStdout' => true,
            'AttachStderr' => true,
            'Cmd' => ['sh', '-c', $command],
        ]);

        if (!$execSetup->successful()) return "Failed to create exec instance.";
        $execId = $execSetup->json()['Id'];

        try {
            // This prevents the Laravel container from freezing if a command takes too long.
            $execStart = $this->client()
                ->timeout(15) 
                ->post("{$this->baseUrl}/exec/{$execId}/start", [
                    'Detach' => false,
                    'Tty' => false,
                ]);

            return $execStart->body();
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // If it times out, we assume it's running in the background.
            return "\x1b[1;33m[PROCESS STARTED] The command is taking a long time. It has been moved to the background. Please check the logs in a few moments for results.\x1b[0m";
        }
    }

    public function getAllLogs() {
        if(Auth::user() && !Auth::user()->can('view docker logs')) return null;

        $response = $this->client()->get("{$this->baseUrl}/containers/{$this->containerName}/logs", [
            'stdout' => true,
            'stderr' => true,
            'tail'   => 'all',
        ]);

        return $response->successful() ? $response->body() : null;
    }

    public function parseLogStream($rawLogs) {
        if (!$rawLogs) return '';

        if (strlen($rawLogs) < 8 || substr($rawLogs, 1, 3) !== "\x00\x00\x00") {
            return $rawLogs;
        }

        $output = '';
        $position = 0;
        $len = strlen($rawLogs);

        while ($position < $len) {
            if (($position + 8) > $len) break;
            $header = substr($rawLogs, $position, 8);
            $payloadSize = unpack('N', substr($header, 4, 4))[1];
            $output .= substr($rawLogs, $position + 8, $payloadSize);
            $position += (8 + $payloadSize);
        }

        return $output ?: $rawLogs;
    }
}