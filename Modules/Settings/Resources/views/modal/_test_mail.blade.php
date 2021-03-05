<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">📤 Testing Email</h4>
        </div>

        {!! Form::open(['route' => 'settings.send.mail', 'class' => 'bs-example ajaxifyForm']) !!}
        <div class="p-2">
            <x-alert type="warning" icon="regular/bell" class="text-sm leading-5">
                If email test fails, check your <a class="font-semibold text-blue-700" href="/settings/mail">Email Settings</a>
            </x-alert>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label class="control-label">Email @required</label>
                <input type="email" class="form-control" name="recipient" placeholder="you@domain.com" value="{{auth()->user()->email}}" required>

            </div>

            <div class="form-group">
                <label class="control-label">@langapp('subject') @required</label>
                <input type="text" class="form-control" name="subject" value="Test email" placeholder="Test Email" required>
            </div>


            <div class="form-group">
                <label class="control-label">@langapp('message')</label>
                <textarea name="message" class="form-control ta"
                    placeholder="Test email">This is a test email to confirm that Workice email configuration is working properly.</textarea>
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
@include('partial.ajaxify')
@endpush

@stack('pagescript')