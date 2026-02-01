<?php

namespace App\Livewire\Admin\ServerMods\Manager;

use App\Models\ServerMod;
use App\Services\CurseforgeService;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use WireUi\Traits\WireUiActions;
use ZipArchive;

class Curseforge extends Component
{
    use WireUiActions;

    #region Properties
    protected CurseforgeService $curseforge;
    public string $searchQuery = '';
    public int $currentPage = 1;
    public array $searchedMods = [];
    #endregion

    #region Lifecycle
    public function boot(CurseforgeService $curseforge) {
        $this->curseforge = $curseforge;
    }

    public function mount() {
        $this->syncLocalMods(); 
        $this->searchForMod();
    }
    #endregion

    #region Computed Properties
    #[Computed]
    public function installedMods(){
        return ServerMod::orderBy('name')->get();
    }

    #[Computed]
    public function installedModMap() {
        return $this->installedMods()
            ->whereNotNull('curse_id')
            ->pluck('curse_id')
            ->flip()
            ->toArray();
    }
    #endregion

    #region Listeners
    #[On('mod-installed')] 
    public function refreshModStatus() {
        unset($this->installedMods);
        unset($this->installedModMap);

        $map = $this->installedModMap();

        $this->searchedMods = collect($this->searchedMods)->map(function ($mod) use ($map) {
            $mod['is_installed'] = isset($map[$mod['id']]);
            return $mod;
        })->toArray();
    }
    #endregion

    #region Search & Pagination
    public function updatedSearchQuery() {
        $this->currentPage = 1;
        $this->searchForMod();
    }

    public function nextPage() {
        $this->searchForMod($this->currentPage + 1);
    }

    public function previousPage() {
        if ($this->currentPage > 1)
            $this->searchForMod($this->currentPage - 1);
    }

    #[Computed]
    public function canLoadMore(): bool {
        return count($this->searchedMods) >= 20;
    }

    public function searchForMod(int $page = 1) {
        $this->currentPage = $page;

        if (empty($this->searchQuery))
            $results = $this->curseforge->getFeaturedMods()['popular'] ?? [];
        else
            $results = $this->curseforge->searchMods($this->searchQuery, $page);

        // Processing: Check if installed via map
        $this->searchedMods = collect($results)->map(function ($mod) {
            $mod['is_installed'] = isset($this->installedModMap()[$mod['id']]);
            return $mod;
        })->toArray();
    }
    #endregion

    #region File Management (Smart Sync)
    public function syncLocalMods() {
        $path = env('GAME_DATA_PATH', base_path('data')) . '/mods';

        if (!File::exists($path))
            return;

        $diskFiles = collect(File::files($path))->keyBy(fn($f) => $f->getFilename());
        $dbFiles   = ServerMod::pluck('file_name', 'file_name');

        $newFiles     = $diskFiles->diffKeys($dbFiles);
        $deletedFiles = $dbFiles->diffKeys($diskFiles);

        if ($deletedFiles->isNotEmpty())
            ServerMod::whereIn('file_name', $deletedFiles->keys())->delete();

        foreach ($newFiles as $filename => $file) {
            $metadata = $this->extractMetadata($file->getRealPath());

            ServerMod::create([
                'file_name'   => $filename,
                'name'        => $metadata['name'],
                'author_name' => $metadata['author'],
                'version'     => $metadata['version'],
                'curse_id'    => null,
            ]);
        }

        if ($newFiles->isNotEmpty() || $deletedFiles->isNotEmpty())
            unset($this->installedMods);
    }
    #endregion

    #region Helpers
    private function extractMetadata(string $path): array {
        $metadata = [
            'name' => basename($path),
            'version' => 'Unknown',
            'author' => 'Unknown',
        ];

        $zip = new ZipArchive;
        if ($zip->open($path) !== true) return $metadata;

        // Try JSON Manifests (Fabric/Quilt/MC)
        foreach (['manifest.json', 'mod.json', 'fabric.mod.json'] as $jsonFile) {
            if ($content = $zip->getFromName($jsonFile)) {
                $json = json_decode($content, true);
                $json = $json[0] ?? $json; 

                if ($json) {
                    $metadata['name'] = $json['Name'] ?? $json['name'] ?? $json['DisplayName'] ?? $metadata['name'];
                    $metadata['version'] = $json['Version'] ?? $json['version'] ?? $metadata['version'];
                    
                    // Handle Author variations
                    $authors = $json['Authors'] ?? $json['authors'] ?? $json['Author'] ?? null;
                    if (is_array($authors)) {
                        // Handle [{"name": "Author"}] or ["Author"]
                        $metadata['author'] = implode(', ', array_map(function($a) {
                            return is_array($a) ? ($a['name'] ?? $a['Name'] ?? '') : $a;
                        }, $authors));
                    } elseif (is_string($authors))
                        $metadata['author'] = $authors;

                    $zip->close();
                    return $metadata;
                }
            }
        }

        // Try TOML Configs (Forge/NeoForge)
        if ($content = $zip->getFromName('META-INF/mods.toml')) {
            if (preg_match('/displayName\s*=\s*"([^"]+)"/', $content, $m)) $metadata['name'] = $m[1];
            if (preg_match('/version\s*=\s*"([^"]+)"/', $content, $m)) $metadata['version'] = $m[1];
            if (preg_match('/authors\s*=\s*"([^"]+)"/', $content, $m)) $metadata['author'] = $m[1];
        }

        $zip->close();
        return $metadata;
    }

    public function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    #endregion

    #region Mod Management
    public function installMod($modId) {
        $mod = collect($this->searchedMods)->firstWhere('id', $modId);

        if (!$mod) {
            $this->notification()->error('Error', 'Mod details could not be resolved.');
            return;
        }

        $latestFile = $mod['latestFiles'][0] ?? null;

        if (!$latestFile || empty($latestFile['downloadUrl'])) {
            $this->notification()->error('Download Failed', 'No download URL available for this mod.');
            return;
        }

        $fileName = $latestFile['fileName'];
        $baseDir = env('GAME_DATA_PATH', base_path('data')) . '/mods';
        $fullPath = $baseDir . '/' . $fileName;

        try {
            if (!File::exists($baseDir))
                File::makeDirectory($baseDir, 0755, true);

            $fileContent = Http::get($latestFile['downloadUrl'])->body();
            
            if (empty($fileContent))
                throw new \Exception("Downloaded file content is empty.");

            File::put($fullPath, $fileContent);

            ServerMod::updateOrCreate(
                ['curse_id' => $mod['id']],
                [
                    'name'          => $mod['name'],
                    'slug'          => $mod['slug'],
                    'author_name'   => $mod['authors'][0]['name'] ?? 'Unknown',
                    'summary'       => $mod['summary'] ?? '',
                    'thumbnail_url' => $mod['logo']['thumbnailUrl'] ?? '',
                    'file_name'     => $fileName,
                    'version'       => $latestFile['displayName'] ?? 'Latest',
                    'mod_url'       => $mod['links']['websiteUrl'] ?? '',
                ]
            );

            $this->notification()->success('Mod Installed', "{$mod['name']} was successfully added.");
            $this->dispatch('mod-installed'); 
        } catch (\Exception $e) {
            $this->notification()->error('Installation Error', $e->getMessage());
        }
    }

    public function deleteMod($id) {
        try {
            $mod = ServerMod::findOrFail($id);
            $baseDir = env('GAME_DATA_PATH', base_path('data')) . '/mods';
            $fullPath = $baseDir . '/' . $mod->file_name;

            if (File::exists($fullPath))
                File::delete($fullPath);

            $mod->delete();
            $this->notification()->success('Mod Removed', "{$mod->name} has been uninstalled.");
            $this->dispatch('mod-installed'); // <--- Added this dispatch
        } catch (\Exception $e) {
            $this->notification()->error('Error', 'Could not delete mod: ' . $e->getMessage());
        }
    }
    #endregion

    public function render() {
        return view('livewire.admin.server-mods.manager.curseforge');
    }
}