<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Genre;
use App\Models\Plateforme;

class LibraryController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'api_id' => 'required',
            'title' => 'required',
            'type' => 'required|in:film,serie,jeu',
            'poster' => 'nullable|string',
            'release_date' => 'nullable|string',
            'overview' => 'nullable|string',
            'rating_api' => 'nullable|numeric',
            'genres' => 'nullable|array',
            'plateformes' => 'nullable|array',
        ]);

        $user = auth()->user();

        // Convertir la date si elle est valide, sinon NULL
        $releaseDate = $data['release_date'] ?? null;
        if ($releaseDate === 'Date inconnue' || empty($releaseDate)) {
            $releaseDate = null;
        }

        $item = Item::firstOrCreate(
            ['api_id' => $data['api_id'], 'type' => $data['type']],
            [
                'title' => $data['title'],
                'poster' => $data['poster'] ?? null,
                'release_date' => $releaseDate,
                'overview' => $data['overview'] ?? null,
                'rating_api' => $data['rating_api'] ?? null,
            ]
        );

        // Associer les genres
        if (!empty($data['genres'])) {
            foreach ($data['genres'] as $g) {
                $genre = Genre::firstOrCreate(['name' => $g]);
                $item->genres()->syncWithoutDetaching([$genre->id]);
            }
        }

        // Associer les plateformes (si c’est un jeu)
        if (!empty($data['plateformes']) && $data['type'] === 'jeu') {
            foreach ($data['plateformes'] as $p) {
                $plateforme = Plateforme::firstOrCreate(['name' => $p]);
                $item->plateformes()->syncWithoutDetaching([$plateforme->id]);
            }
        }

        // Lier à l’utilisateur
        $user->items()->syncWithoutDetaching([
            $item->id => ['status' => 'a_voir']
        ]);

        return back()->with('success', "{$data['title']} ajouté à ta bibliothèque !");
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'status' => 'required|in:a_voir,en_cours,termine,abandonne',
            'rating' => 'nullable|numeric|min:0|max:10',
            'review' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();
        $item = Item::findOrFail($data['item_id']);

        // Vérifier que l'item appartient à l'utilisateur
        if (!$user->items()->where('item_id', $item->id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Item non trouvé dans votre bibliothèque'], 404);
        }

        // Mettre à jour les données dans la table pivot
        $user->items()->updateExistingPivot($item->id, [
            'status' => $data['status'],
            'rating' => $data['rating'] ?? null,
            'review' => $data['review'] ?? null,
        ]);

        return response()->json(['success' => true, 'message' => 'Modifications sauvegardées']);
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
        ]);

        $user = auth()->user();
        $item = Item::findOrFail($data['item_id']);

        // Vérifier que l'item appartient à l'utilisateur
        if (!$user->items()->where('item_id', $item->id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Item non trouvé dans votre bibliothèque'], 404);
        }

        // Retirer l'item de la bibliothèque
        $user->items()->detach($item->id);

        return response()->json(['success' => true, 'message' => 'Item retiré de votre bibliothèque']);
    }
}
