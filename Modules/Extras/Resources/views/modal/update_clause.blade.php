<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/pencil-alt') @langapp('make_changes') </h4>
        </div>

        {!! Form::open(['route' => ['clauses.api.update', $clause->id], 'class' => 'ajaxifyForm', 'method' => 'PUT']) !!}

        <div class="modal-body">
            <div class="form-group">
                <label class="control-label">@langapp('clause') @required </label>
                <x-inputs.wysiwyg name="clause" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                    {{ $clause->clause}}
                </x-inputs.wysiwyg>
            </div>
        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            {!! renderAjaxButton() !!}
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

@stack('pagescript')