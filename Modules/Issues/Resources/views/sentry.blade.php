<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{ __('Sentry Integration') }}</h4>
        </div>

        {!! Form::open(['class' => 'bs-example form-horizontal']) !!}

        <div class="modal-body prose-lg text-sm">

            <p class="text-gray-700">
                Sentry Webhooks make it easy for integrations to consume important events from Sentry, like when Issues are created.
            </p>
            <p class="text-gray-700">
                {{ __('Once an issue is created on Sentry it will appear in this project issues section') }}
            </p>
            <p class="text-gray-700 font-semibold">
                Copy the url below and add it to your list of sentry <a class="text-indigo-600" href="https://docs.sentry.io/product/integrations/integration-platform/webhooks/"
                    target="_blank">webhook</a> urls.
            </p>
            <div class="form-group">
                <label class="col-lg-3 control-label">Webhook URL</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" value="{{ route('sentry.incoming', $token) }}">
                </div>
            </div>
            <div class="line line-dashed"></div>


        </div>


        <div class="modal-footer">
            {!! closeModalButton() !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>