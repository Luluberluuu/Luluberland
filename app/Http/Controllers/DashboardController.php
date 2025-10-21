<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 🔹 Tous les items de l'utilisateur
        $items = $user->items()->with(['genres','plateformes'])->get();

        // 🔹 Séparer par type
        $jeux = $items->where('type', 'jeu')->values();
        $films = $items->where('type', 'film')->values();
        $series = $items->where('type', 'serie')->values();

        // 🔹 Tous les items pour le carrousel
        $featuredItems = $items->take(10); // Limiter à 10 items pour le carrousel

        return view('dashboard', [
            'featuredItems' => $featuredItems,
            'jeux' => $jeux,
            'films' => $films,
            'series' => $series
        ]);
    }
}
