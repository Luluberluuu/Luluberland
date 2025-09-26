<x-app-layout>
    @if ($errors->has('api'))
        <div class="bg-red-600 text-white p-3 rounded mb-4">
            {{ $errors->first('api') }}
        </div>
    @endif

    @if(!empty($results) && is_array($results))
        <div class="grid grid-cols-4 gap-4 p-6 bg-gray-900 text-white">
            @foreach($results as $item)
                @if(is_array($item))
                    <div class="bg-gray-800 p-3 rounded shadow">
                        @if($type === 'film' || $type === 'serie')
                            <img src="https://image.tmdb.org/t/p/w200{{ $item['poster_path'] ?? '' }}"
                                class="rounded mb-2">
                            <h3 class="font-bold">{{ $item['title'] ?? $item['name'] }}</h3>
                        @elseif($type === 'jeu')
                            <img src="{{ $item['background_image'] ?? '' }}" class="rounded mb-2">
                            <h3 class="font-bold">{{ $item['name'] }}</h3>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</x-app-layout>