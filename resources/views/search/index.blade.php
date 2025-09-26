<x-app-layout>
    <form action="{{ route('search.run') }}" method="POST" class="p-4 flex gap-2">
        @csrf
        <input type="text" name="q" placeholder="Rechercher..."
            class="p-2 border rounded w-full">

        <select name="type" class="p-2 border rounded">
            <option value="film">Film</option>
            <option value="serie">Série</option>
            <option value="jeu">Jeu</option>
        </select>

        <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded">
            Chercher
        </button>
    </form>
</x-app-layout>