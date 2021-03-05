@props([
'for',
'value' => '',
'type' => 'password'
])
<div class="rounded-md shadow-sm">
    <input type="{{ $type }}" value="{{ $value }}"
        {{ $attributes->merge(['class' => 'block w-full bg-white border border-gray-200 py-2 px-3 rounded-lg transition duration-150 ease-in-out sm:text-sm sm:leading-5']) }}
        id="{{ $for }}" />
</div>