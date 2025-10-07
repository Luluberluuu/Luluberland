<x-app-layout>
    <div class="bg-grisclair rounded-[30px] h-full w-full p-6">
        <form action="{{ route('search.run') }}" method="POST" class="p-4 flex gap-2">
            @csrf
            <input type="text" name="q" placeholder="Rechercher..."
                class="px-4 py-2 border-2 border-transparent focus:ring-0 outline-0 focus:outline-0 focus:border-global rounded-lg w-64 bg-white text-noirlight shadow-sm">

            <select name="type" class="w-64 px-4 py-2 border-2 border-transparent outline-none focus:ring-0 focus:outline-none focus:border-global rounded-lg shadow-sm">
                <option disabled selected>Sélectionnez votre média</option>
                <option value="film">Film</option>
                <option value="serie">Série</option>
                <option value="jeu">Jeu</option>
            </select>

            <button type="submit"
                    class="bg-global text-noirlight px-4 py-2 rounded-lg transition duration-300 hover:bg-noirlight hover:text-global">
                Chercher
            </button>
        </form>
    </div>
</x-app-layout>