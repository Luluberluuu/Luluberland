<x-app-layout>
    <div class="bg-grisclair rounded-[30px] h-full w-full p-6">
        @if ($errors->has('api'))
            <div class="bg-red-600 text-white p-3 rounded mb-4">
                {{ $errors->first('api') }}
            </div>
        @endif

        @if(!empty($results) && is_array($results))
            <div class="grid grid-cols-4 gap-8 justify-stretch">
                @foreach($results as $item)
                    @if(is_array($item))
                        @php
                            // 🔹 Déterminer le titre
                            $title = $item['title'] ?? $item['name'] ?? 'Titre inconnu';

                            // 🔹 Déterminer l’image (poster)
                            if (!empty($item['poster_path'])) {
                                $poster = 'https://image.tmdb.org/t/p/w300' . $item['poster_path'];
                            } elseif (!empty($item['background_image'])) {
                                $poster = $item['background_image'];
                            } else {
                                $poster = asset('img/default.jpg');
                            }

                            // 🔹 Date de sortie
                            $release = $item['release_date'] 
                                ?? $item['first_air_date'] 
                                ?? $item['released'] 
                                ?? 'Date inconnue';
                        @endphp

                        <div class="rounded-[25px] w-auto border-2 border-transparent transition duration-300 relative hover:border-global hover:-translate-y-0.5 bg-black/5 overflow-hidden">
                            <img src="{{ $poster }}" alt="{{ $title }}" class="object-cover object-center rounded-[25px] w-full h-[30vh]">

                            <div class="absolute bottom-0 p-4 bg-card-item w-full h-full rounded-[25px] transition duration-300 flex flex-col justify-end z-50">
                                <h3 class="text-lg font-extrabold text-white mb-1 truncate">{{ $title }}</h3>
                                <p class="text-white text-sm">{{ $release }}</p>

                                

                                {{-- Bouton + Toast --}}
                                <div 
                                    x-data="{ added: {{ in_array($item['id'], $userItemIds) ? 'true' : 'false' }}, showToast: false }"
                                    class="flex flex-col"
                                >
                                    {{-- Toast --}}
                                    <div 
                                        x-show="showToast" 
                                        x-transition:enter="transition ease-out duration-500"
                                        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                        x-transition:leave="transition ease-in duration-300"
                                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                                        x-init="$watch('showToast', value => { if (value) setTimeout(() => showToast = false, 2000) })"
                                        class="flex items-center gap-3 bg-gradient-to-r from-green-500 via-green-400 to-green-600 text-white text-sm px-5 py-3 rounded-xl mb-2 shadow-2xl border-2 border-white/20 animate-pulse"
                                        style="backdrop-filter: blur(4px);"
                                    >
                                        <svg class="w-6 h-6 text-white drop-shadow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2.5" fill="#22c55e" />
                                            <path stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M8 12.5l2.5 2.5 5-5"/>
                                        </svg>
                                        <span class="font-semibold tracking-wide drop-shadow">Ajouté à ta bibliothèque !</span>
                                    </div>

                                    {{-- Si déjà ajouté --}}
                                    <button x-show="added" disabled
                                        class="mt-4 w-fit flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-lg cursor-not-allowed transition duration-300"
                                        style="backdrop-filter: blur(2px);">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2.5" fill="#22c55e" />
                                            <path stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M8 12.5l2.5 2.5 5-5"/>
                                        </svg>
                                        Déjà ajouté
                                    </button>

                                    {{-- Si non ajouté --}}
                                    @php
                                        $payload = [
                                            'api_id' => $item['id'],
                                            'title' => $title,
                                            'type' => $type,
                                            'poster' => $poster,
                                            'release_date' => $release,
                                            'overview' => $item['overview'] ?? '',
                                            'rating_api' => $item['vote_average'] ?? $item['rating'] ?? '',
                                            'genres' => isset($item['genres'])
                                                ? array_map(fn($g) => is_array($g) ? ($g['name'] ?? '') : $g, $item['genres'])
                                                : [],
                                            'plateformes' => isset($item['platforms'])
                                                ? array_map(fn($p) => $p['platform']['name'] ?? '', $item['platforms'])
                                                : [],
                                        ];
                                    @endphp

                                    <form 
                                        x-show="!added"
                                        x-on:submit.prevent="
                                            added = true;
                                            showToast = true;
                                            const payload = JSON.parse($el.dataset.payload);
                                            fetch('{{ route('library.store') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Accept': 'application/json',
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify(payload)
                                            });
                                        "
                                        data-payload='@json($payload)'
                                    >
                                        <button type="submit"
                                            class="mt-4 flex items-center gap-2 bg-global hover:bg-noirlight hover:text-global px-3 py-2 rounded-lg text-sm text-noirlight font-semibold shadow-md transition duration-300 group">
                                            <svg class="w-5 h-5 text-noirlight group-hover:text-global transition duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Ajouter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>