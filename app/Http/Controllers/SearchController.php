<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Services\RawgService;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function search(Request $request, TmdbService $tmdb, RawgService $rawg)
    {
        $query = $request->input('q');
        $type  = $request->input('type');

        $results = [];

        if ($type === 'film') {
            $results = $tmdb->searchMovie($query);
        } elseif ($type === 'serie') {
            $results = $tmdb->searchTv($query);
        } elseif ($type === 'jeu') {
            $results = $rawg->searchGame($query);
        }

        if (isset($results['error'])) {
            return back()->withErrors([
                'api' => "Erreur API ({$results['status']}) : " . json_encode($results['body'])
            ])->withInput();
        }

        $user = auth()->user();

        // 🔹 récupérer les api_id des items déjà ajoutés
        $userItemIds = $user->items()
            ->where('type', $type)
            ->pluck('api_id')
            ->toArray();

        return view('search.results', [
            'results' => $results,
            'type' => $type,
            'userItemIds' => $userItemIds,
        ]);
    }
}
