<div class="modal-dialog">
    <div class="modal-content">
        <div class="p-2 border-b border-gray-300">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="text-xl text-gray-600 modal-title">
                @icon('solid/trash-alt') @langapp('delete')
            </h4>
        </div>
        {!! Form::open(['route' => ['timers.api.delete', $entry->id], 'method' => 'DELETE', 'class' => 'ajaxifyForm'])
        !!}
        <div class="text-sm prose-lg modal-body">

            <div class="mb-2 bg-red-100 border-red-600 alert">@langapp('delete_warning')</div>

            <input type="hidden" name="id" value="{{ $entry->id }}">
            <div>@langapp('time_spent') : <span class="text-semibold">{{ secToHours($entry->worked) }}</span></div>
            <div>@langapp('billable') : <span class="text-semibold">{{ $entry->billable ? langapp('yes') : langapp('no') }}</span></div>
            <div>@langapp('date') : <span class="text-semibold">{{ $entry->created_at->toDayDateTimeString() }}</span>
            </div>
            <div>@langapp('user') : <span class="text-indigo-600 text-semibold">{{ $entry->user->name }}</span></div>

            <blockquote class="text-sm">
                {{ $entry->notes }}
            </blockquote>

        </div>
        <div class="modal-footer">

            {!! closeModalButton() !!}
            {!! renderAjaxButton('ok') !!}

        </div>
        {!! Form::close() !!}
    </div>
</div>
@include('partial.ajaxify')