<li class="list-group-item" draggable="true" id="source-{{ $source->id }}">
	<span class="pull-right">
		<a href="{{ route('settings.sources.edit', $source->id) }}" data-toggle="ajaxModal" data-dismiss="modal">
			@icon('solid/pencil-alt', 'text-gray-600 fa-fw m-r-xs')
		</a>
		<a href="#" class="deleteSource" data-source-id="{{ $source->id }}">
			@icon('solid/times', 'text-gray-600 fa-fw')
		</a>
	</span>
	<div class="clear">{{ $source->name }}</div>
</li>