@props(['value'])

<label {{ $attributes->merge(['class' => 'px-2 py-2 text-sm font-medium  text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
