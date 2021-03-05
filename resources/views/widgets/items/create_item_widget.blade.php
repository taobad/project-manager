<tr class="hidden-print">

	<input type="hidden" name="module_id" value="{{ $module_id }}">
	<input type="hidden" name="module" value="{{ $module }}">
	<input type="hidden" name="order" value="{{ $order }}">
	<input type="hidden" name="json" value="false">
	<input id="hidden-item-name" type="hidden" name="name">
	<td></td>
	<td>
		<input id="auto-item-name" data-scope="{{ $scope }}" type="text" placeholder="@langapp('product')" class="typeahead form-control">
	</td>
	<td>
		<textarea id="auto-item-desc" rows="1" name="description" placeholder="@langapp('description')" class="form-control js-auto-size"></textarea>
	</td>
	<td>
		<input id="auto-quantity" type="text" name="quantity" value="1" class="form-control">
	</td>
	@php $scope = $scope == 'credits' ? 'creditnote' : $scope; @endphp
	@if ($withTaxes)
	<td>
		<select name="tax_rate[]" class="w-full select2-tags form-control" multiple>
			<option value="" selected>@langapp('none')</option>
			@foreach (App\Entities\TaxRate::all() as $key => $tax)
			<option value="{{ $tax->id }}" {{ get_option( 'default_tax') == $tax->rate ? ' selected' : '' }}>
				{{ $tax->name }}</option>
			@endforeach
		</select>
	</td>
	@endif
	<td>
		<input id="auto-unit-cost" type="text" name="unit_cost" value="0.00" class="text-right form-control" required>
	</td>
	@if ($withDiscount)
	<td>
		<input id="auto-discount" type="text" name="discount" placeholder="0.00" value="0.00" class="text-right form-control money">
	</td>
	@endif
	<td></td>
	<td>{!! renderAjaxButton() !!}</td>
</tr>