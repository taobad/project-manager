<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-{{ get_option('theme_color') }}">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/envelope-open') @langapp('send') @langapp('email') - {{ $contact->email }}</h4>
        </div>
        {!! Form::open(['route' => 'contacts.send', 'class' => 'ajaxifyForm', 'files' => true]) !!}

        <input type="hidden" name="url" value="{{ url()->previous() }}">


        <div class="modal-body">
            <div class="form-group">
                <label class="control-label">@langapp('subject') @required</label>
                <input type="text" class="form-control" value="{{ optional($contact->emails->first())->subject }}" name="subject">

            </div>
            <div class="form-group">
                <label>@langapp('message') @required</label>
                <x-inputs.wysiwyg name="message" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                </x-inputs.wysiwyg>
            </div>
            <div class="form-group">
                <label class="control-label">@langapp('attach_file') </label>
                <input type="file" name="uploads[]" multiple="">
            </div>

            <input type="hidden" name="id" value="{{  $contact->id  }}">
        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            {!! renderAjaxButton('send') !!}
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
@stack('pagestyle')