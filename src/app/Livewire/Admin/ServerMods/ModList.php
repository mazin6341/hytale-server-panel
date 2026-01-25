<?php

namespace App\Livewire\Admin\ServerMods;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;

class ModList extends Component
{
    use WithFileUploads;
    use WireUiActions;

    public $modFiles = [];
    public $mods = [];

    public function mount() {
        if (Auth::user()->can('view server mods')) {
            $this->loadMods();
        }
    }

    public function loadMods() {
        if (!Auth::user()->can('view server mods')) {
            $this->mods = [];
            return;
        }

        $path = $this->getModsPath();

        if (!File::exists($path)) return;

        $this->mods = collect(File::files($path))
            ->map(function ($file) {
                $filePath = $file->getRealPath();
                // $cacheKey = 'mod_meta_' . md5($filePath . $file->getMTime());

                $metadata = $this->getMetadataFromZip($filePath);

                return [
                    'filename' => $file->getFilename(),
                    'name' => $metadata['name'],
                    'version' => $metadata['version'],
                    'author' => $metadata['author'],
                    'size' => $this->formatBytes($file->getSize()),
                    'path' => $filePath,
                ];
            })
            ->toArray();
    }

    public function uploadMod() {
        if (!Auth::user()->can('manage server mods')) {
            $this->notification()->error('Permission Denied', 'You do not have permission to upload mods.');
            return;
        }

        $this->validate([
            'modFiles.*' => 'required|file|max:102400|mimes:zip,jar',
        ]);

        try {
            $destinationPath = $this->getModsPath();
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Refresh existing mods to ensure we have the latest list for comparison
            $this->loadMods();
            $existingMods = collect($this->mods);

            foreach ($this->modFiles as $tempFile) {
                $tempPath = $tempFile->getRealPath();
                $newMetadata = $this->getMetadataFromZip($tempPath);
                $fileName = basename($tempFile->getClientOriginalName());

                // Check if this mod (by Name) already exists in our server
                $existing = $existingMods->firstWhere('name', $newMetadata['name']);

                if ($existing) {
                    // version_compare returns: -1 (older), 0 (equal), 1 (newer)
                    $comparison = version_compare($newMetadata['version'], $existing['version']);

                    if ($comparison > 0) {
                        // It's a newer version: Delete the old file (even if it has a different filename)
                        if (File::exists($existing['path'])) {
                            File::delete($existing['path']);
                        }
                        
                        File::copy($tempPath, $destinationPath . '/' . $fileName);
                        $this->notification()->info("Updated: {$newMetadata['name']} to v{$newMetadata['version']}");
                    } else {
                        // Older or same version: Skip
                        $this->notification()->warning(
                            "Skipped: {$newMetadata['name']}",
                            "A version ({$existing['version']}) is already up to date."
                        );
                        continue; 
                    }
                } else {
                    // Completely new mod: Just upload
                    File::copy($tempPath, $destinationPath . '/' . $fileName);
                }
            }

            $this->modFiles = [];
            $this->loadMods();

            $this->notification()->success('Upload process completed.');
        } catch (\Throwable $th) {
            $this->notification()->error('Failed to upload mod(s).', $th->getMessage());
        }
    }

    public function deleteFile($fileName) {
        if (!Auth::user()->can('manage server mods')) {
            $this->notification()->error('Permission Denied', 'You do not have permission to delete mods.');
            return;
        }

        $path = $this->getModsPath() . '/' . basename($fileName);

        if (File::exists($path)) {
            File::delete($path);
            $this->loadMods();
            session()->flash('success', 'Mod deleted successfully.');
        } else {
            session()->flash('error', 'Mod file not found.');
        }
    }

    #region Helpers
    private function getMetadataFromZip($path) {
        $metadata = [
            'name' => basename($path),
            'version' => 'Unknown',
            'author' => 'Unknown',
        ];

        $zip = new \ZipArchive;
        if ($zip->open($path) === TRUE) {
            // TEMP
            // $temp = [];
            // for ($i = 0; $i < $zip->numFiles; $i++) {
            //     $stat = $zip->statIndex($i);
            //     $temp[] = $stat['name']; 
            // }
            // dd($temp);
            // STOP TEMP
            foreach (['manifest.json', 'mod.json'] as $i => $file) {
                if ($content = $zip->getFromName($file)) {
                    $json = json_decode($content, true);
                    
                    if (isset($json[0])) $json = $json[0]; 
                    
                    if ($json) {
                        $metadata['name'] = $json['Name'] ?? $json['DisplayName'] ?? $metadata['name'];
                        $metadata['version'] = $json['Version'] ?? 'Unknown';
                        
                        $authors = !empty($json['Authors']) ? $json['Authors'] : $json['Author'] ?? $json['Group'] ?? null;
                        $metadata['author'] = is_array($authors) ? implode(', ', collect($authors)->map(fn($author) => $author['Name'])->toArray()) : ($authors ?? 'Unknown');
                        
                        $zip->close();
                        return $metadata;
                    }
                }
            }

            if ($content = $zip->getFromName('META-INF/mods.toml')) {
                preg_match('/displayName\s*=\s*"([^"]+)"/', $content, $nameMatch);
                preg_match('/version\s*=\s*"([^"]+)"/', $content, $verMatch);
                preg_match('/authors\s*=\s*"([^"]+)"/', $content, $authMatch);

                $metadata['name'] = $nameMatch[1] ?? $metadata['name'];
                $metadata['version'] = $verMatch[1] ?? 'Unknown';
                $metadata['author'] = $authMatch[1] ?? 'Unknown';
            }

            $zip->close();
        }

        return $metadata;
    }

    private function getModsPath() {
        return env('GAME_DATA_PATH', base_path('data')) . '/mods';
    }

    private function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    #endregion

    public function render() {
        return view('livewire.admin.server-mods.mod-list');
    }
}