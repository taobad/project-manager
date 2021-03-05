<div class="modal-dialog">
    <div class="modal-content">
        <div class="p-2 border-b border-gray-300">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="text-xl text-gray-600 modal-title">
                @icon('solid/clock') @langapp('time_entry') - <span class="{{themeText()}}">{{ $entry->user->name }}</span>
            </h4>
        </div>

        <div class="modal-body">

            @if($entry->is_started)
            <div class="pull-right">
                @icon('solid/sync-alt', 'fa-spin fa-5x text-red-400')
            </div>

            @endif

            <div class="py-1">
                <span>@langapp('name') :</span>
                <span class="font-semibold text-gray-600">{{ $entry->timeable->name }}</span>
            </div>
            @if($entry->task_id > 0)
            <div class="py-1">
                <span>@langapp('task') :</span>
                <span class="font-semibold text-indigo-600">
                    <a href="{{ route('projects.view',['project' => $entry->timeable->id,'tab' => 'tasks', 'item' => $entry->task_id]) }}">
                        {{ optional($entry->task)->name }}
                    </a>
                </span>
            </div>
            @endif

            <div class="py-2">
                <span>@langapp('date') :</span>
                <span class="font-semibold text-gray-600">{{ $entry->created_at->toDayDateTimeString() }}</span>
            </div>
            <div class="py-2">
                <span>@langapp('billable') :</span>
                <span class="font-semibold text-gray-600">{{ $entry->billable ? langapp('yes') : langapp('no') }}</span>
            </div>
            <div class="py-2">
                <span>@langapp('billed') :</span>
                <span class="font-semibold text-gray-600">{{ $entry->billed ? langapp('yes') : langapp('no') }}</span>
            </div>
            <div class="py-2">
                <span>@langapp('start') :</span>
                <span class="font-semibold text-gray-600">@icon('regular/clock', 'text-gray-700') {{ $entry->start ? dateTimeFormatted( dateFromUnix($entry->start) ) : '' }}</span>
            </div>
            <div class="py-2">
                <span>@langapp('stop') :</span>
                <span class="font-semibold text-gray-600">@icon('regular/clock', 'text-gray-500') {{ $entry->end ? dateTimeFormatted( dateFromUnix($entry->end) ) : '' }}</span>
            </div>
            <div class="py-2">
                <span>@langapp('total_time') :</span>
                <span class="font-semibold text-gray-600">{{ secToHours($entry->worked) }}</span>
            </div>
            <div class="py-2 text-sm prose-lg">
                @parsedown($entry->notes)
            </div>
        </div>

    </div>


</div>