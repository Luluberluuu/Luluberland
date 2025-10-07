@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-noir border-gray-200 focus:border-global focus:ring-global rounded-lg transition duration-300']) }}>
