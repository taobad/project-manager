<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('make_changes') </h4>
        </div>

        {!! Form::open(['route' => ['notes.change', $note->id], 'class' => 'ajaxifyForm']) !!}

        <input type="hidden" name="id" value="{{  $note->id  }}">

        <div class="modal-body">

            <div class="form-group">
                <label>@langapp('notes')</label>
                <x-inputs.wysiwyg name="description" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                    {{ $note->getRawOriginal('description')}}
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

@stack('pagestyle')
@stack('pagescript')