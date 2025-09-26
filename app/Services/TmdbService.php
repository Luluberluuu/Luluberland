<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    private string $baseUrl = 'https://api.themoviedb.org/3';

    public function searchMovie(string $query): array
    {
        $response = Http::acceptJson()->get("{$this->baseUrl}/search/movie", [
            'api_key' => env('TMDB_API_KEY'),
            'query'   => $query,
            'language'=> 'fr-FR',
        ]);

        if (!$response->successful()) {
            return [
                'error'  => true,
                'status' => $response->status(),
                'body'   => $response->json() ?: $response->body()
            ];
        }

        return $response->json()['results'] ?? [];
    }

    public function searchTv(string $query): array
    {
        $response = Http::acceptJson()->get("{$this->baseUrl}/search/tv", [
            'api_key' => env('TMDB_API_KEY'),
            'query'   => $query,
            'language'=> 'fr-FR',
        ]);

        if (!$response->successful()) {
            return [
                'error'  => true,
                'status' => $response->status(),
                'body'   => $response->json() ?: $response->body()
            ];
        }

        return $response->json()['results'] ?? [];
    }
}