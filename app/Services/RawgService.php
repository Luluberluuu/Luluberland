<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RawgService
{
    private string $baseUrl = 'https://api.rawg.io/api';

    public function searchGame(string $query): array
    {
        $r = Http::acceptJson()->get("{$this->baseUrl}/games", [
            'key' => env('RAWG_API_KEY'),
            'search' => $query,
            'page_size' => 20,
        ]);

        if (!$r->successful()) {
            return ['error' => true, 'status' => $r->status(), 'body' => $r->json() ?: $r->body()];
        }

        return $r->json()['results'] ?? [];
    }
}