@if ($type === 'warning')
<div {{ $attributes->merge(['class' => 'p-3 m-1 text-yellow-900 bg-yellow-100 border-t-4 border-yellow-500 rounded-b shadow-md']) }}>
    @icon($icon,'inline w-4 h-4 text-yellow-900') {{$slot}}
</div>
@elseif ($type === 'danger')
<div {{ $attributes->merge(['class' => 'p-3 m-1 text-red-900 bg-red-100 border-t-4 border-red-500 rounded-b shadow-md']) }}>
    @icon($icon,'inline w-4 h-4 text-red-900') {{$slot}}
</div>
@else
<div {{ $attributes->merge(['class' => 'p-3 m-1 text-teal-900 bg-green-100 border-t-4 border-green-500 rounded-b shadow-md']) }}>
    @icon($icon,'inline w-4 h-4 text-green-900') {{$slot}}
</div>
@endif