@if (get_option('htmleditor') == 'easyMDE')
<x-editors.easyMDE name="{{ $name }}" id="{{ $id }}" {{ $attributes->merge(['class' => 'form-control']) }}>
    {{ old($name, $slot) }}
</x-editors.easyMDE>
@endif
@if (get_option('htmleditor') == 'summernoteEditor')
<x-inputs.textarea name="{{ $name }}" id="{{ $id }}" {{ $attributes->merge(['class' => 'form-control']) }}>
    {{ old($name, $slot) }}
</x-inputs.textarea>
@endif
@if (get_option('htmleditor') == 'markdownEditor')
<x-inputs.textarea name="{{ $name }}" id="{{ $id }}" {{ $attributes->merge(['class' => 'form-control']) }}>
    {{ old($name, $slot) }}
</x-inputs.textarea>
@endif