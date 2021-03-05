<li class="list-group-item" draggable="true" id="calendar-{{ $calendar->id }}">
	<span class="pull-right">
		<a href="{{ route('settings.calendars.edit', $calendar->id) }}" data-toggle="ajaxModal" data-dismiss="modal">
			@icon('solid/pencil-alt', 'text-gray-600 fa-fw m-r-xs')
		</a>
		<a href="#" class="deleteCalendar" data-calendar-id="{{ $calendar->id }}">
			@icon('solid/times', 'text-gray-600 fa-fw')
		</a>
	</span>
	<div class="clear">{{ $calendar->name }}</div>
</li>