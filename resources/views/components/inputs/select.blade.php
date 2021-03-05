@props([
'for',
'name',
])
<select name="{{$name}}" {{ $attributes->merge(['class' => 'm-1 p-2 rounded border w-full appearance-none']) }} id="{{ $for }}">
    {{ $slot }}
</select>