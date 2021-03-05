<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('reminder') </h4>
        </div>

        {!! Form::open(['route' => ['invoices.api.reminder', $invoice->id], 'class' => 'bs-example ajaxifyForm']) !!}

        <div class="modal-body">
            <input type="hidden" name="id" value="{{  $invoice->id  }}">

            <div class="form-group">
                <label class="">@langapp('subject') @required</label>
                <input type="text" class="form-control" name="subject" value="@langmail('invoices.reminder.reminder1.subject', ['code' => $invoice->reference_no])">

            </div>

            <p class="text-center m-lg">
                {!! (new Modules\Invoices\Emails\PoliteReminder($invoice, null, null, false))->render() !!}

            </p>

            <div class="form-group">
                <x-inputs.wysiwyg name="message" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">

                </x-inputs.wysiwyg>

            </div>

            <div class="form-group">
                <label class="text-muted">Cc</label>

                <select class="select2-tags form-control" name="cc[]" multiple>
                    @foreach($invoice->company->contacts as $contact)
                    <option value="{{ $contact->user->email  }}" {{ $contact->id === $invoice->company->primary_contact ? 'selected="selected"' : '' }}>{{  $contact->user->email }}
                    </option>
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

<script type="text/javascript">
    $(function () {
        $('.submit').click(function () {
            var mysave = $('.message').html();
            $('.hiddenmessage').val(mysave);
        });
    });
</script>
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