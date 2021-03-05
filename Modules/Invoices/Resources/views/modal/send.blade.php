<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/paper-plane') @langapp('send') - {{ $invoice->name }}</h4>
        </div>
        {!! Form::open(['route' => ['invoices.api.send', $invoice->id], 'class' => 'bs-example ajaxifyForm']) !!}

        <div class="modal-body">
            <input type="hidden" name="id" value="{{ $invoice->id }}">
            <div class="form-group">
                <label class="">@langapp('to') @required</label>
                <input type="text" class="form-control" value="{{ $invoice->company->email }}" name="to" readonly>
            </div>


            <div class="form-group">
                <label class="">@langapp('subject') @required</label>

                <input type="text" class="form-control" value="@langmail('invoices.sending.subject', ['name' => get_option('company_name'), 'code' => $invoice->reference_no])"
                    name="subject">

            </div>

            <p class="text-center m-lg">
                {!! (new Modules\Invoices\Emails\InvoiceMail($invoice, null, null, false))->render() !!}

            </p>
            <div class="form-group">
                <x-inputs.wysiwyg name="message" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">

                </x-inputs.wysiwyg>

            </div>
            <div class="form-group">
                <div class="form-check text-muted m-t-xs">
                    <label>
                        <input type="checkbox" name="attach" checked value="1">
                        <span class="label-text" data-rel="tooltip" title="Attach Invoice as PDF">Attach Invoice PDF to email</span>
                    </label>
                </div>

            </div>
            <div class="form-group">
                <label class="text-muted">Cc</label>
                <select class="select2-tags form-control" name="cc[]" multiple>
                    @foreach($invoice->company->contacts as $contact)
                    <option value="{{ $contact->user->email  }}" {{ $contact->id === $invoice->company->primary_contact ? 'selected' : '' }}>{{ $contact->user->name }}</option>
                    @endforeach
                </select>


            </div>
            <div class="form-group">
                <label class="text-muted">Bcc</label>
                <select class="select2-tags form-control" name="bcc[]" multiple>
                    <option value="{{  Auth::user()->email  }}">{{  Auth::user()->email }}</option>
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
@push('pagescript')
@include('stacks.js.wysiwyg')
@include('stacks.js.form')
@include('partial.ajaxify')
@endpush
@stack('pagescript')