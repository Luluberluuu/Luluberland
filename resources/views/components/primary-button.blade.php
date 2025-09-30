<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 bg-jaune border border-transparent rounded-lg font-semibold text-xs text-noirlight uppercase tracking-widest hover:bg-noirlight hover:text-jaune transition ease-in-out duration-300']) }}>
    {{ $slot }}
</button>
