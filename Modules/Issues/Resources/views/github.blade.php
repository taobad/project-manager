<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{ __('Github Integration') }}</h4>
        </div>

        {!! Form::open(['class' => 'bs-example form-horizontal']) !!}

        <div class="modal-body prose-lg text-sm">

            <div class="alert bg-indigo-100 border-indigo-600 mb-2">
                {{ __('Once an issue is created on Github it will appear in this project issues section.') }}
            </div>
            <ul>
                <li>{{ __('Copy the url below and add it to your list of Github webhook urls') }}</li>
            </ul>
            <div class="form-group">
                <label class="col-lg-3 control-label">Webhook URL</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" value="{{ route('github.incoming', $token) }}">
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