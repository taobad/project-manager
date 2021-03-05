<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/pencil-alt') @langapp('make_changes') </h4>
        </div>

        {!! Form::open(['route' => ['responses.api.update', $response->id], 'class' => 'ajaxifyForm', 'method' => 'PUT']) !!}

        <input type="hidden" name="user_id" value="{{ Auth::id() }}">


        <div class="modal-body">


            <div class="form-group">
                <label class="control-label">@langapp('subject') @required</label>
                <input type="text" class="form-control" name="subject" placeholder="Lead Intro" value="{{ $response->subject }}" required>

            </div>

            <div class="form-group">
                <label class="control-label">@langapp('message') @required </label>
                <x-inputs.wysiwyg name="message" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                    {{ $response->message}}
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