<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/pencil-alt') @langapp('make_changes') </h4>
        </div>

        {!! Form::open(['route' => ['announcements.api.update', $announcement->id], 'class' => 'ajaxifyForm', 'method' => 'PUT']) !!}

        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <input type="hidden" name="announce_at" value="{{ now()->addMinutes(30) }}">


        <div class="modal-body">

            <div class="row">
                <div class="col-md-6">
                    <label>@langapp('subject') @required</label>
                    <input type="text" value="{{ $announcement->subject }}" name="subject" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>URL</label>
                    <input type="text" value="{{ $announcement->url }}" name="url" class="form-control">
                </div>
            </div>


            <div class="form-group">
                <label class="control-label">@langapp('message') @required </label>
                <x-inputs.wysiwyg name="message" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                    {!!$announcement->message!!}
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
@include('stacks.css.wysiwyg');
@endpush

@push('pagescript')
@include('stacks.js.wysiwyg')
@include('partial.ajaxify')
@endpush

@stack('pagestyle')
@stack('pagescript')