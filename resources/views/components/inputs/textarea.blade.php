<textarea name="{{ $name }}" id="{{ $id }}" rows="{{ $rows }}" {{ $attributes->merge(['class' => 'block w-full p-2 mt-1']) }}>{{ old($name, $slot) }}</textarea>