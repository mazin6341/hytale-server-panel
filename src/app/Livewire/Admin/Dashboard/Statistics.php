<?php

namespace App\Livewire\Admin\Dashboard;

use App\Services\DockerService;
use Livewire\Component;

class Statistics extends Component
{
    public array $stats = [
        'cpu' => '0.00',
        'memory' => '0.00',
        'memory_limit' => '0.00',
        'memory_pct' => '0.00',
        'net_io' => '0 / 0',
    ];

    public function getDockerStats() {
        $docker = new DockerService();

        if(!$docker->isRunning()) {
            $this->stats = [
                'cpu' => '0.00',
                'memory' => '0.00',
                'memory_limit' => '0.00',
                'memory_pct' => '0.00',
                'net_io' => '0 / 0',
            ];
            return;
        }
        
        $data = $docker->getStats();

        if (!$data) return;

        // 1. Calculate CPU Percentage
        // Formula: (delta_cpu / delta_system) * number_of_cores * 100
        $cpuDelta = $data['cpu_stats']['cpu_usage']['total_usage'] - $data['precpu_stats']['cpu_usage']['total_usage'];
        $systemDelta = $data['cpu_stats']['system_cpu_usage'] - $data['precpu_stats']['system_cpu_usage'];
        $cpuPct = 0.00;
        if ($systemDelta > 0 && $cpuDelta > 0) {
            $cpuPct = ($cpuDelta / $systemDelta) * count($data['cpu_stats']['cpu_usage']['percpu_usage'] ?? [1]) * 100.0;
        }

        // 2. Memory Usage (Convert bytes to MB/GB)
        $memUsage = $data['memory_stats']['usage'] ?? 0;
        $memLimit = $data['memory_stats']['limit'] ?? 0;
        $memPct = $memLimit > 0 ? ($memUsage / $memLimit) * 100 : 0;

        // 3. Network IO
        $rx = $data['networks']['eth0']['rx_bytes'] ?? 0;
        $tx = $data['networks']['eth0']['tx_bytes'] ?? 0;

        $this->stats = [
            'cpu' => number_format($cpuPct, 2),
            'memory' => $this->formatBytes($memUsage),
            'memory_limit' => $this->formatBytes($memLimit),
            'memory_pct' => number_format($memPct, 2),
            'net_io' => $this->formatBytes($rx) . ' / ' . $this->formatBytes($tx),
        ];
    }

    private function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function render() {
        return view('livewire.admin.dashboard.statistics');
    }
}