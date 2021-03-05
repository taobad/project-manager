<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@svg('solid/trash-alt') @langapp('delete') @langapp('ticket') </h4>
        </div>
        {!! Form::open(['route' => ['tickets.api.delete', $ticket->id], 'method' => 'DELETE', 'class' => 'ajaxifyForm']) !!}
        <div class="modal-body">

            <div class="alert bg-red-100 border-red-600 mb-2">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p>@icon('solid/exclamation-triangle')@langapp('delete_warning')</p>
            </div>

            <div class="prose-lg text-sm text-gray-600">
                <p>
                    @langapp('subject') : <strong class="text-red-600">{{ $ticket->subject }}</strong><br>
                    @langapp('reporter') : <strong class="text-red-600">{{ $ticket->user->name }}</strong><br>
                    @langapp('status') : <strong class="uppercase">@langapp($ticket->AsStatus->status)</strong><br>
                </p>
            </div>



            <input type="hidden" name="id" value="{{  $ticket->id  }}">

        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            {!! renderAjaxButton('ok') !!}

        </div>

        {!! Form::close() !!}
    </div>
</div>
@include('partial.ajaxify')