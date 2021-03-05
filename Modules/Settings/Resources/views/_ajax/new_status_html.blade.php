<li class="list-group-item" draggable="true" id="status-{{ $status->id }}">
	<span class="pull-right">
		<a href="{{ route('settings.statuses.edit', $status->id) }}" data-toggle="ajaxModal" data-dismiss="modal">
			@icon('solid/pencil-alt', 'text-gray-600 fa-fw m-r-xs')
		</a>
		<a href="#" class="deleteStatus" data-status-id="{{ $status->id }}">
			@icon('solid/times', 'text-gray-600 fa-fw')
		</a>
	</span>
	<div class="clear">{{ $status->status }}</div>
</li>