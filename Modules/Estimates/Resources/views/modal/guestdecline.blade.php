<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-danger">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@svg('solid/trash-alt') {{  langapp('decline')  }} {{$estimate->reference_no }} - {{  formatCurrency($estimate->currency, $estimate->amount) }}
            </h4>
        </div>
        {!! Form::open(['url' => URL::signedRoute('estimates.guestcancel', $estimate->id), 'class' => 'bs-example ajaxifyForm']) !!}

        <div class="modal-body">
            <p>Any feedback on why the estimate is declined?</p>

            <input type="hidden" name="status" value="Declined">
            <input type="hidden" name="rejected_time" value="{{ now()->toDateTimeString() }}">

            <div class="form-group">
                <label class="control-label">@langapp('reason') </label>
                <x-inputs.wysiwyg name="rejected_reason" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">

                </x-inputs.wysiwyg>
            </div>

        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}

            {!! renderAjaxButton('ok', 'fa fa-times-circle') !!}

        </div>
        {!! Form::close() !!}
    </div>
</div>

@push('pagestyle')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.wysiwyg')
@include('partial.ajaxify')
@endpush

@stack('pagestyle')
@stack('pagescript')