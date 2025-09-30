@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-normal text-md text-white']) }}>
    {{ $value ?? $slot }}
</label>
