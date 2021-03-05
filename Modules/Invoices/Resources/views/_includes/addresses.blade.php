@php $data['company'] = $customer; @endphp
<div class="well m-t">
    <div class="row">
        @if (get_option('swap_to_from') == 'FALSE')
        <div class="col-xs-6">
            <strong>@langapp('received_from'):</strong>
            @include('partial.company_address', $data)
        </div>
        @endif 
        <div class="col-xs-6">
            <strong>@langapp('bill_to'):</strong>
            <div class="pmd-card-body">
                @include('partial.client_address', $data)
            </div>
            @can('invoices_update')
            @if ($customer->unbilledExpenses() > 0)
            <span class="text-info hidden-print">
                <a href="#" class="btn btn-xs btn-danger" data-toggle="ajaxModal">@langapp('expenses_available') </a>
            </span>
            @endif
            @endcan
        </div>
        @if (get_option('swap_to_from') == 'TRUE')
        <div class="col-xs-6">
            <strong>@langapp('received_from'):</strong>
            @include('partial.company_address', $data)
        </div>
        @endif
    </div>
</div>