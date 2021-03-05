@props(['label', 'for'])
<div class="m-1">
    <label for="{{ $for }}" {{ $attributes->merge(['class' => 'block text-gray-700']) }}>
        {{ $label }}
        {{ $slot }}
    </label>
</div>