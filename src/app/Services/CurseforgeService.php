<?php

namespace App\Services;

use App\Models\AppSetting;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class CurseforgeService {
    
    protected PendingRequest $http;

    public function __construct() {
        $details = $this->getBaseDetails();

        $this->http = Http::withHeaders([
            'x-api-key' => $details['apiKey'],
            'Accept' => 'application/json',
        ])->baseUrl($details['url']);
    }

    private function getBaseDetails(): array {
        $url = AppSetting::where('section', 'Hidden')->where('name', 'CurseForge API URL')->first()?->getValue() ?? 'https://api.curseforge.com';
        $userApi = AppSetting::where('section', 'Mod Management')->where('name', 'CurseForge API Key')->first()?->getValue();

        // Return with user API key if it works, otherwise return Hidden CurseForge API key
        if (!empty($userApi) && $this->confirmAccess($userApi, $url))
            return [
                'url' => $url,
                'apiKey' => $userApi
            ];

        return [
            'url' => $url,
            'apiKey' => AppSetting::where('section', 'Hidden')->where('name', 'CurseForge API Key')->first()?->getValue()
        ];
    }

    /**
     * Confirm API Access
     */
    public function confirmAccess(string $key, string $url) {
        $http = Http::withHeaders([
            'x-api-key' => $key,
            'Accept' => 'application/json',
        ])->baseUrl($url);

        $response = $http->get('/v1/games/70216');
        return $response->successful();
    }

    /**
     * Get featured mods
     */
    public function getFeaturedMods() {
        $response = $this->http->post('/v1/mods/featured', [
            'gameId' => 70216,
        ]);
        return $response->json('data');
    }

    /**
     * Search for mods
     */
    public function searchMods(string $search = '', int $index = 0, int $pageSize = 20) {
        $response = $this->http->get('/v1/mods/search', [
            'gameId' => 70216,
            'searchFilter' => $search,
            'index' => $index,
            'pageSize' => $pageSize,
        ]);

        return $response->json('data');
    }

    /**
     * Get specific details for a single mod
     */
    public function getMod(int $modId) {
        $response = $this->http->get("/v1/mods/{$modId}");
        return $response->json('data');
    }

    /**
     * Get the files (versions) for a specific mod
     */
    public function getModFiles(int $modId) {
        $response = $this->http->get("/v1/mods/{$modId}/files");
        return $response->json('data');
    }

    /**
     * Get categories specific to Hytale
     */
    public function getCategories() {
        $response = $this->http->get('/v1/categories', [
            'gameId' => 70216
        ]);
        return $response->json('data');
    }
}