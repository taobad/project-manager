<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('mark_as_lost') - {{ $deal->title }}</h4>
        </div>
        {!! Form::open(['route' => ['deals.api.close', $deal->id], 'class' => 'ajaxifyForm', 'data-toggle' => 'validator']) !!}
        <div class="modal-body">
            <input type="hidden" name="id" value="{{  $deal->id }}">
            <input type="hidden" name="lost_time" value="{{  now()->toDateTimeString()  }}">
            <input type="hidden" name="status" value="lost">

            <div class="form-group">
                <label class="control-label">@langapp('lost_reason') </label>
                <x-inputs.wysiwyg name="lost_reason" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">

                </x-inputs.wysiwyg>
            </div>
        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            {!! renderAjaxButton('mark_as_lost', null, true) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@push('pagescript')
@include('stacks.js.wysiwyg')
@include('partial.ajaxify')
@endpush

@stack('pagescript')