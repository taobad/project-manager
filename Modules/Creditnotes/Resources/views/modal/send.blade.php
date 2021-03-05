<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/paper-plane') @langapp('send') - {{ $creditnote->name }}</h4>
        </div>
        {!! Form::open(['route' => ['creditnotes.api.send', $creditnote->id], 'class' => 'bs-example ajaxifyForm']) !!}

        <div class="modal-body">
            <input type="hidden" name="id" value="{{  $creditnote->id  }}">
            <div class="form-group">
                <label class="">@langapp('to') @required</label>
                <input type="text" class="form-control" value="{{ $creditnote->company->email }}" name="to" readonly>
            </div>

            <div class="form-group">
                <label class="">@langapp('subject') @required</label>

                <input type="text" class="form-control" value="@langmail('credits.sending.subject', ['company' => get_option('company_name')])" name="subject">

            </div>

            <p class="text-center m-lg">
                {!! (new Modules\Creditnotes\Emails\CreditNoteMail($creditnote, null, null, false))->render() !!}

            </p>
            <div class="form-group">
                <x-inputs.wysiwyg name="message" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">

                </x-inputs.wysiwyg>
            </div>

            <div class="form-group">
                <div class="form-check text-muted m-t-xs">
                    <label>
                        <input type="checkbox" name="attach" value="1">
                        <span class="label-text" data-rel="tooltip" title="Attach Credit Note as PDF">Attach Credit Note PDF to email</span>
                    </label>
                </div>

            </div>

            <div class="form-group">
                <label class="text-muted">Cc</label>
                <select class="select2-tags form-control" name="cc[]" multiple>
                    @if($creditnote->company->primary_contact > 0)
                    <option value="{{ $creditnote->company->contact->email }}" selected="selected">{{ $creditnote->company->contact->email }}</option>
                    @endif
                </select>


            </div>
            <div class="form-group">
                <label class="text-muted">Bcc</label>
                <select class="select2-tags form-control" name="bcc[]" multiple>
                    <option value="{{ Auth::user()->email }}">{{ Auth::user()->email }}</option>
                </select>


            </div>

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
@include('stacks.js.form')
@include('partial.ajaxify')
@endpush
@stack('pagestyle')
@stack('pagescript')