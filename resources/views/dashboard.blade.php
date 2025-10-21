<x-app-layout>
    <div class="bg-grisclair rounded-[30px] h-full w-full p-4">
        <div class="h-full overflow-y-auto scrollbar-thin scrollbar-thumb-global scrollbar-track-grisclair p-4">

            {{-- ✅ SECTION 1 : CARROUSEL D'ITEMS EN VEDETTE --}}
        @if($featuredItems->count() > 0)
            <div class="relative w-full h-[64vh] rounded-[30px] overflow-hidden shadow-lg bg-flou bg-flou-filter mb-10">
                <div id="featured-carousel" class="relative w-full h-full">
                    @foreach($featuredItems as $index => $featured)
                        <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}" 
                             data-index="{{ $index }}">
                            <img src="{{ $featured->poster ?? asset('img/default.jpg') }}" 
                                alt="{{ $featured->title }}"
                                class="object-cover object-center w-full h-full brightness-75 select-none pointer-events-none">
                            <div class="absolute inset-0 bg-gradient-to-t from-noir via-noir/60 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 w-full px-10 pb-10 pt-8 bg-gradient-to-t from-noir/70 via-black/30 to-transparent z-10 rounded-b-[30px]">
                                <h1 class="text-4xl font-extrabold mb-3 text-global drop-shadow-lg">{{ $featured->title }}</h1>
                                <p class="text-grisclair text-base max-w-2xl line-clamp-3 font-medium mb-2">
                                    {{ $featured->overview ?? 'Aucune description disponible.' }}
                                </p>
                                <p class="text-noirlight bg-global/80 rounded-full inline-block px-4 py-1 text-sm font-semibold mt-1 shadow">
                                    {{ ucfirst($featured->type) }} 
                                    @if($featured->release_date)
                                        • {{ date('Y', strtotime($featured->release_date)) }}
                                    @else
                                        • Date inconnue
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Indicateurs de progression --}}
                <div class="absolute top-6 right-6 flex space-x-2 z-20">
                    @foreach($featuredItems as $index => $featured)
                        <div class="carousel-indicator w-2 h-2 rounded-full bg-white/40 cursor-pointer transition-all duration-300 {{ $index === 0 ? 'bg-white scale-125' : '' }}"
                             data-index="{{ $index }}"></div>
                    @endforeach
                </div>

                {{-- Compteur de temps --}}
                <div class="absolute top-6 left-6 z-20">
                    <div class="bg-black/50 backdrop-blur-sm rounded-full px-3 py-1">
                        <span class="text-white text-sm font-medium">
                            <span id="current-slide">{{ 1 }}</span> / {{ $featuredItems->count() }}
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-flou bg-flou-filter text-noirlight p-10 rounded-[30px] text-center border-2 border-global/40 mb-10">
                <img src="{{ asset('images/l-key.png') }}" alt="Logo clé" class="mx-auto mb-6 opacity-40" width="70">
                <span class="text-lg font-semibold">Aucun contenu dans ta bibliothèque pour l'instant.</span>
            </div>
        @endif

            {{-- ✅ SECTION 2 : JEUX --}}
            @if($jeux->count())
                <div class="mt-6">
                    <div class="flex items-center justify-between px-4">
                        <h2 class="text-2xl font-bold text-noirlight flex items-center gap-2">
                            <span class="text-3xl">🎮</span> Jeux
                        </h2>
                        <div class="flex gap-2">
                            <button class="carousel-btn prev-btn bg-global text-noirlight px-3 py-1 rounded-full hover:bg-global/80 transition flex items-center justify-center" data-carousel="jeux" aria-label="Précédent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.5 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button class="carousel-btn next-btn bg-global text-noirlight px-3 py-1 rounded-full hover:bg-global/80 transition flex items-center justify-center" data-carousel="jeux" aria-label="Suivant">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.5 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="section-carousel" id="carousel-jeux">
                        <div class="carousel-container">
                            @foreach($jeux as $jeu)
                                <div class="carousel-item">
                                    <div class="rounded-[25px] bg-flou bg-flou-filter border-2 border-transparent hover:border-global transition overflow-hidden group shadow relative cursor-pointer hover:scale-[1.03] item-card"
                                         data-item-id="{{ $jeu->id }}"
                                         data-title="{{ $jeu->title }}"
                                         data-type="{{ $jeu->type }}"
                                         data-poster="{{ $jeu->poster ?? asset('img/default.jpg') }}"
                                         data-overview="{{ $jeu->overview ?? 'Aucune description disponible.' }}"
                                         data-release-date="{{ $jeu->release_date ? date('Y', strtotime($jeu->release_date)) : 'Date inconnue' }}"
                                         data-rating-api="{{ $jeu->rating_api ?? 'N/A' }}"
                                         data-genres="{{ $jeu->genres->pluck('name')->join(', ') }}"
                                         data-platforms="{{ $jeu->plateformes->pluck('name')->join(', ') }}"
                                         data-user-status="{{ $jeu->pivot->status ?? 'a_voir' }}"
                                         data-user-rating="{{ $jeu->pivot->rating ?? 0 }}"
                                         data-user-review="{{ $jeu->pivot->review ?? '' }}">
                                        <img src="{{ $jeu->poster ?? asset('img/default.jpg') }}" 
                                            alt="{{ $jeu->title }}" 
                                            class="group-hover:brightness-90 transition">
                                        <div class="absolute inset-0 bg-card-item opacity-0 group-hover:opacity-100 transition"></div>
                                        <div class="absolute bottom-0 p-4 bg-card-item w-full h-full rounded-[25px] transition duration-300 flex flex-col justify-end z-50">
                                            <h3 class="font-bold text-grisclair text-base">{{ $jeu->title }}</h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- ✅ SECTION 3 : FILMS --}}
            @if($films->count())
                <div class="mt-10">
                    <div class="flex items-center justify-between px-4">
                        <h2 class="text-2xl font-bold text-noirlight flex items-center gap-2">
                            <span class="text-3xl">🎬</span> Films
                        </h2>
                        <div class="flex gap-2">
                            <button class="carousel-btn prev-btn bg-global text-noirlight px-3 py-1 rounded-full hover:bg-global/80 transition" data-carousel="films">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.5 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button class="carousel-btn next-btn bg-global text-noirlight px-3 py-1 rounded-full hover:bg-global/80 transition" data-carousel="films">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.5 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="section-carousel" id="carousel-films">
                        <div class="carousel-container">
                            @foreach($films as $film)
                                <div class="carousel-item">
                                    <div class="rounded-[25px] bg-flou bg-flou-filter border-2 border-transparent hover:border-global transition overflow-hidden group shadow relative cursor-pointer hover:scale-[1.03] item-card"
                                         data-item-id="{{ $film->id }}"
                                         data-title="{{ $film->title }}"
                                         data-type="{{ $film->type }}"
                                         data-poster="{{ $film->poster ?? asset('img/default.jpg') }}"
                                         data-overview="{{ $film->overview ?? 'Aucune description disponible.' }}"
                                         data-release-date="{{ $film->release_date ? date('Y', strtotime($film->release_date)) : 'Date inconnue' }}"
                                         data-rating-api="{{ $film->rating_api ?? 'N/A' }}"
                                         data-genres="{{ $film->genres->pluck('name')->join(', ') }}"
                                         data-platforms=""
                                         data-user-status="{{ $film->pivot->status ?? 'a_voir' }}"
                                         data-user-rating="{{ $film->pivot->rating ?? 0 }}"
                                         data-user-review="{{ $film->pivot->review ?? '' }}">
                                        <img src="{{ $film->poster ?? asset('img/default.jpg') }}" 
                                            alt="{{ $film->title }}" 
                                            class="group-hover:brightness-90 transition">
                                        <div class="absolute inset-0 bg-card-item opacity-0 group-hover:opacity-100 transition"></div>
                                        <div class="absolute bottom-0 p-4 bg-card-item w-full h-full rounded-[25px] transition duration-300 flex flex-col justify-end z-50">
                                            <h3 class="font-bold text-grisclair text-base">{{ $film->title }}</h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- ✅ SECTION 4 : SERIES --}}
            @if($series->count())
                <div class="mt-10">
                    <div class="flex items-center justify-between px-4">
                        <h2 class="text-2xl font-bold text-noirlight flex items-center gap-2">
                            <span class="text-3xl">📺</span> Séries
                        </h2>
                        <div class="flex gap-2">
                            <button class="carousel-btn prev-btn bg-global text-noirlight px-3 py-1 rounded-full hover:bg-global/80 transition" data-carousel="series">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.5 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button class="carousel-btn next-btn bg-global text-noirlight px-3 py-1 rounded-full hover:bg-global/80 transition" data-carousel="series">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.5 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="section-carousel" id="carousel-series">
                        <div class="carousel-container">
                            @foreach($series as $serie)
                                <div class="carousel-item">
                                    <div class="rounded-[25px] bg-flou bg-flou-filter border-2 border-transparent hover:border-global transition overflow-hidden group shadow relative cursor-pointer hover:scale-[1.03] item-card"
                                         data-item-id="{{ $serie->id }}"
                                         data-title="{{ $serie->title }}"
                                         data-type="{{ $serie->type }}"
                                         data-poster="{{ $serie->poster ?? asset('img/default.jpg') }}"
                                         data-overview="{{ $serie->overview ?? 'Aucune description disponible.' }}"
                                         data-release-date="{{ $serie->release_date ? date('Y', strtotime($serie->release_date)) : 'Date inconnue' }}"
                                         data-rating-api="{{ $serie->rating_api ?? 'N/A' }}"
                                         data-genres="{{ $serie->genres->pluck('name')->join(', ') }}"
                                         data-platforms=""
                                         data-user-status="{{ $serie->pivot->status ?? 'a_voir' }}"
                                         data-user-rating="{{ $serie->pivot->rating ?? 0 }}"
                                         data-user-review="{{ $serie->pivot->review ?? '' }}">
                                        <img src="{{ $serie->poster ?? asset('img/default.jpg') }}" 
                                            alt="{{ $serie->title }}" 
                                            class="group-hover:brightness-90 transition">
                                        <div class="absolute inset-0 bg-card-item opacity-0 group-hover:opacity-100 transition"></div>
                                        <div class="absolute bottom-0 p-4 bg-card-item w-full h-full rounded-[25px] transition duration-300 flex flex-col justify-end z-50">
                                            <h3 class="font-bold text-grisclair text-base">{{ $serie->title }}</h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal pour afficher les détails de l'item --}}
    <div id="itemModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-noirlight rounded-[30px] w-2/4 max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    {{-- Header de la modal --}}
                    <div class="flex justify-between items-start mb-6">
                        <h2 id="modalTitle" class="text-3xl font-bold text-global"></h2>
                        <button id="closeModal" class="text-white hover:text-global transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex gap-8">
                        {{-- Image et infos de base --}}
                        <div class="w-1/3 flex flex-col">
                            <img id="modalPoster" src="" alt="" class="w-full h-full object-cover rounded-[20px] mb-4">
                            <div class="bg-noir/30 rounded-[20px] p-4 h-auto">
                                <h3 class="text-xl font-bold text-global mb-3">Informations</h3>
                                <div class="space-y-2 text-grisclair">
                                    <p><span class="font-semibold text-white">Type:</span> <span id="modalType"></span></p>
                                    <p><span class="font-semibold text-white">Date de sortie:</span> <span id="modalReleaseDate"></span></p>
                                    <p><span class="font-semibold text-white">Note API:</span> <span id="modalRatingApi"></span>/10</p>
                                    <p><span class="font-semibold text-white">Genres:</span> <span id="modalGenres"></span></p>
                                    <div id="modalPlatforms" class="hidden">
                                        <p><span class="font-semibold text-white">Plateformes:</span> <span id="modalPlatformsList"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Formulaire de modification --}}
                        <div class="w-2/3">
                            <form id="itemForm" class="flex flex-col gap-6 h-full">
                                <input type="hidden" id="itemId" name="item_id">
                                
                                {{-- Statut --}}
                                <div>
                                    <label class="block text-white font-semibold mb-2">Statut</label>
                                    <select id="itemStatus" name="status" class="w-full bg-noir text-white px-4 py-3 border-gray-200 focus:border-global focus:ring-global rounded-lg transition duration-300">
                                        <option value="a_voir">À voir</option>
                                        <option value="en_cours">En cours</option>
                                        <option value="termine">Terminé</option>
                                        <option value="abandonne">Abandonné</option>
                                    </select>
                                </div>

                                {{-- Note personnelle --}}
                                <div>
                                    <label class="block text-white font-semibold mb-2">Ma note</label>
                                    <div class="flex items-center gap-2">
                                        <input type="range" id="itemRating" name="rating" min="0" max="10" step="0.5" value="0" 
                                               class="flex-1 h-1 bg-grisclair rounded-lg appearance-none cursor-pointer slider">
                                        <span id="ratingValue" class="text-global font-bold min-w-[3rem]">0</span>
                                    </div>
                                </div>

                                {{-- Avis/Description --}}
                                <div>
                                    <label class="block text-white font-semibold mb-2">Mon avis</label>
                                    <textarea id="itemReview" name="review" rows="6" 
                                              class="w-full bg-noir text-white border-gray-200 focus:border-global focus:ring-global rounded-lg transition duration-300 px-4 py-3 focus:outline-none resize-none"
                                              placeholder="Partagez votre avis sur ce contenu..."></textarea>
                                </div>

                                {{-- Description originale --}}
                                <div>
                                    <label class="block text-white font-semibold mb-2">Description</label>
                                    <div id="modalOverview" class="w-full text-xs bg-noir text-white border-gray-200 focus:border-global focus:ring-global rounded-lg transition duration-300 px-4 py-3 max-h-32 overflow-y-auto">
                                    </div>
                                </div>

                                {{-- Boutons d'action --}}
                                <div class="flex justify-end gap-4 pt-4 mt-auto">
                                    <button type="submit" class="px-4 py-3 bg-green-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-400 hover:text-white transition ease-in-out duration-300 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Sauvegarder
                                    </button>
                                    <button type="button" id="removeFromLibrary" class="px-4 py-3 bg-red-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-400 hover:text-white transition ease-in-out duration-300 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Retirer de ma bibliothèque
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast Container --}}
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

</x-app-layout>
