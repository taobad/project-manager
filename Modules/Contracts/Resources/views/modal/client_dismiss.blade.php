<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/file-contract') @langapp('decline')
                - {{ $contract->contract_title }}</h4>
        </div>


        {!! Form::open(['route' => ['contracts.client.reject', $contract->id], 'class' => 'bs-example ajaxifyForm']) !!}

        <div class="modal-body">
            <input type="hidden" name="contract_id" value="{{ $contract->id }}">

            <div class="pb15">

                <div class="form-group">
                    <label class="control-label">@langapp('reject_reason') @required</label>
                    <x-inputs.wysiwyg name="reason" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">

                    </x-inputs.wysiwyg>

                </div>

            </div>

        </div>

        <div class="modal-footer">
            {!! closeModalButton() !!}
            {!! renderAjaxButton('decline', 'fas fa fa-times-circle', true) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>

@include('stacks.css.wysiwyg')
@include('partial.ajaxify')
@include('stacks.js.wysiwyg')