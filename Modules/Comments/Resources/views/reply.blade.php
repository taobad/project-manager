<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('reply')</h4>
        </div>
        {!! Form::open(['route' => 'comments.create', 'class' => 'ajaxifyForm']) !!}

        <div class="modal-body">
            <input type="hidden" name="parent" value="{{  $comment->id  }}">
            <input type="hidden" name="commentable_type" value="{{ $comment->commentable_type }}">
            <input type="hidden" name="commentable_id" value="{{ $comment->commentable_id }}">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">


            <div class="form-group">
                <label>@langapp('message') @required</label>
                <x-inputs.wysiwyg name="message" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                </x-inputs.wysiwyg>
            </div>

        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            {!! renderAjaxButton() !!}

            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('pagescript')
@include('stacks.js.wysiwyg')
@include('partial.ajaxify')
@endpush

@stack('pagescript')