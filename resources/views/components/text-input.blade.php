@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-noir border-gray-200 focus:border-jaune focus:ring-jaune rounded-lg transition duration-300']) }}>
