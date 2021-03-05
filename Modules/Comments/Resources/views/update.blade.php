<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-info">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@svg('solid/pencil-alt') @langapp('make_changes') </h4>
        </div>
        {!! Form::open(['route' => ['comments.update', $comment->id], 'method' => 'PUT', 'class' => 'ajaxifyForm']) !!}

        <div class="modal-body">
            <x-inputs.wysiwyg name="message" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                {{ $comment->getRawOriginal('message')}}
            </x-inputs.wysiwyg>
            <input type="hidden" name="id" value="{{ $comment->id }}">
            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">

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