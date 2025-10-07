<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 bg-global border border-transparent rounded-lg font-semibold text-xs text-noirlight uppercase tracking-widest hover:bg-noirlight hover:text-global transition ease-in-out duration-300']) }}>
    {{ $slot }}
</button>
