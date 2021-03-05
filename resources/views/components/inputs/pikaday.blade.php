<div class="rounded-md shadow-sm">
    <input x-data x-init="new Pikaday({ field: $el {{ $jsonOptions() }} })" name="{{ $name }}" type="text" id="{{ $id }}" placeholder="{{ $placeholder }}"
        @if($value)value="{{ $value }}" @endif
        {{ $attributes->merge(['class' => 'block w-full bg-white border border-gray-200 py-2 px-3 rounded-sm transition duration-150 ease-in-out sm:text-sm sm:leading-5']) }} />
</div>