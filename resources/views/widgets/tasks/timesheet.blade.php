<div class="panel-group m-b" id="accordion2">
  @foreach ($entries as $entry)
  <div class="panel panel-default">
    <div class="panel-heading">
      <a class="text-indigo-500 accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse-entry-{{ $entry->id }}" aria-expanded="false">
        @if($entry->billed)
        <span data-toggle="tooltip" title="Billed" data-placement="right">@icon('solid/check-circle',
          'text-success')</span>
        @endif
        @if($entry->is_started)
        <span data-toggle="tooltip" title="Timer Running" data-placement="right">@icon('solid/clock', 'fa-spin
          text-danger')</span>
        @endif
        <span class="font-semibold">{{ secToHours($entry->worked) }}</span> - <span
          class="text-gray-600">{{ $entry->billable ? langapp('billable') : langapp('unbillable') }}</span> <span
          class="text-muted pull-right">{{ $entry->created_at->toDayDateTimeString() }}</span>
      </a>
    </div>
    <div id="collapse-entry-{{ $entry->id }}" class="panel-collapse collapse" aria-expanded="false">
      <div class="text-sm panel-body">
        @parsedown($entry->notes)

        <div class="flex justify-between mt-2 text-gray-500">

          <a href="{{ route('timetracking.edit', $entry->id) }}" class="btn btn-xs btn-default" data-toggle="ajaxModal">@icon('solid/pencil-alt')</a>

          <a href="{{ route('timetracking.delete', $entry->id) }}" class="btn btn-xs btn-danger" data-toggle="ajaxModal">@icon('solid/trash-alt')</a>




        </div>

      </div>





    </div>
  </div>
  @endforeach


</div>