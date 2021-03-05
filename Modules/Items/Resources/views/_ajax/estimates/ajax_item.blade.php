<tr class="sortable" data-name="{{  $item->name  }}" data-id="{{  $item->id  }}" id="item-{{ $item->id }}">
    <td class="drag-handle">
        @icon('solid/bars')
    </td>
    <td>
        @if(can('estimates_update') && $item->itemable->isEditable())
        <a class="{{themeText('font-semibold')}}" data-toggle="ajaxModal" href="{{ route('items.edit', $item->id) }}">
            {{  $item->name == '' ? '...' : $item->name  }}
        </a>
        @else {{ $item->name }} @endif
    </td>
    <td class="text-gray-600">
        @parsedown($item->description)
    </td>
    <td class="text-right">
        {{ formatQuantity($item->quantity) }}
    </td>
    @if ($item->itemable->tax_per_item == 1)
    <td class="text-right">
        {{ $item->tax_total }}
    </td>
    @endif
    <td class="text-right">
        {{ formatDecimal($item->unit_cost) }}
    </td>
    @if ($item->itemable->discount_per_item == 1)
    <td class="text-right">
        {{ $item->discount }}%
    </td>
    @endif
    <td class="font-semibold text-right text-gray-600">
        {{ formatCurrency($item->itemable->currency, $item->total_cost) }}
    </td>
    <td class="text-right">
        @if(can('estimates_update') && $item->itemable->isEditable())
        <a class="hidden-print deleteItem" data-item-id="{{ $item->id }}" href="#">
            @icon('solid/trash-alt', 'text-danger')
        </a>
        @endif
    </td>
</tr>