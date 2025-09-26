<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TmdbService;
use App\Services\RawgService;

class SearchBar extends Component
{

    public function updatedQuery(TmdbService $tmdb, RawgService $rawg)
    {
        

    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}
