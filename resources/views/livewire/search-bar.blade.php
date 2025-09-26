<div class="p-4">
    <pre>{{ var_export($results, true) }}</pre>
    <p>{{ $query }}</p>
    <div class="flex gap-2">
        <input type="text" wire:model="query"
               placeholder="Rechercher..."
               class="p-2 border rounded w-full">

        <select wire:model="type" class="p-2 border rounded">
            <option value="film">Film</option>
            <option value="serie">Série</option>
            <option value="jeu">Jeu</option>
        </select>
    </div>

    @if(!empty($results))
        <div class="grid grid-cols-4 gap-4 mt-6 bg-gray-900 text-white">
            @foreach($results as $item)
                <div class="bg-gray-800 p-3 rounded shadow">
                    {{-- Films & Séries --}}
                    @if($type === 'film' || $type === 'serie')
                        <img src="https://image.tmdb.org/t/p/w200{{ $item['poster_path'] ?? '' }}"
                             class="rounded mb-2" alt="{{ $item['title'] ?? $item['name'] }}">
                        <h3 class="font-bold">{{ $item['title'] ?? $item['name'] }}</h3>
                        <p class="text-sm text-gray-400">
                            {{ $item['release_date'] ?? $item['first_air_date'] ?? 'Date inconnue' }}
                        </p>
                    @endif

                    {{-- Jeux vidéo --}}
                    @if($type === 'jeu')
                        <img src="{{ $item['background_image'] ?? '' }}"
                             class="rounded mb-2" alt="{{ $item['name'] }}">
                        <h3 class="font-bold">{{ $item['name'] }}</h3>
                        <p class="text-sm text-gray-400">{{ $item['released'] ?? 'Date inconnue' }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @elseif(strlen($query) >= 3)
        <p class="text-gray-400 mt-4">Aucun résultat trouvé.</p>
    @endif
</div>

