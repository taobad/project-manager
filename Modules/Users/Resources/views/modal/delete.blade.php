<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-danger">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('delete') {{  $user->name  }}</h4>
        </div>

        {!! Form::open(['route' => ['users.api.delete', $user->id], 'class' => 'ajaxifyForm', 'method' => 'DELETE']) !!}

        <div class="modal-body">

            <x-alert type="danger" icon="regular/trash-alt" class="text-sm leading-5">
                @langapp('delete_warning')
            </x-alert>
            <input type="hidden" name="checked[]" value="{{  $user->id  }}">

        </div>
        <div class="modal-footer">

            {!! closeModalButton() !!}
            {!! renderAjaxButton('ok') !!}

        </div>

        {!! Form::close() !!}
    </div>
</div>
@include('partial.ajaxify')