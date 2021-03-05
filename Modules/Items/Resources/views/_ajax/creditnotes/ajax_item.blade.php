<tr class="sortable" data-name="{{$item->name}}" data-id="{{$item->id}}">
    <td class="drag-handle">@icon('solid/bars')</td>
    <td class="{{themeText('font-semibold')}}">
        @if (can('credits_update') && $item->itemable->isEditable())
        <a href="{{route('items.edit', $item->id) }}" data-toggle="ajaxModal">
            {{$item->name == '' ? '...' : $item->name}}
        </a>
        @else
        {{$item->name}}
        @endif
    </td>
    <td class="text-gray-600">@parsedown($item->description)</td>
    <td class="text-right">{{ formatQuantity($item->quantity) }}</td>
    @if ($item->itemable->tax_per_item == 1)
    <td class="text-right">
        {{ formatDecimal($item->tax_total) }}
    </td>
    @endif
    <td class="text-right">{{ formatDecimal($item->unit_cost) }}</td>
    <td class="font-semibold text-right text-gray-600">
        {{formatCurrency($item->itemable->currency, $item->total_cost)}}</td>
    <td class="text-right">
        @if (can('credits_update') && $item->itemable->isEditable())
        <a class="hidden-print" href="{{route('items.delete', $item->id)}}" data-toggle="ajaxModal">@icon('solid/trash-alt', 'text-danger')
        </a>
        @endif
    </td>
</tr>