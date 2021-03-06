<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('convert_to_invoice')  {{ $estimate->reference_no }}
                - {{ formatCurrency($estimate->currency, $estimate->amount) }}</h4>
        </div>
        {!! Form::open(['route' => ['estimates.api.invoice', $estimate->id], 'class' => 'ajaxifyForm']) !!}
        <div class="modal-body">
            <p>@langapp('estimate_to_invoice_message', ['code' => $estimate->reference_no])</p>
            <p>
                @langapp('reference_no'): <strong>{{ $estimate->reference_no }}</strong><br>
                @langapp('client'): <strong>{{ $estimate->company->name }}</strong><br>
                @langapp('amount'): <strong>{{ formatCurrency($estimate->currency, $estimate->amount) }}</strong><br>
            </p>

            <input type="hidden" name="id" value="{{ $estimate->id }}">

        </div>
        <div class="modal-footer">
            
        {!! closeModalButton() !!}
        {!! renderAjaxButton('convert_to_invoice') !!}
        
        </div>
        {!! Form::close() !!}
    </div>
</div>
@include('partial.ajaxify')