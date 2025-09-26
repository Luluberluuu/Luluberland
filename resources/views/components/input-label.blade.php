@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-light text-sm text-noir']) }}>
    {{ $value ?? $slot }}
</label>
