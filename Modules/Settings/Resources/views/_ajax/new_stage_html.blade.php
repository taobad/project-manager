<li class="list-group-item" draggable="true" id="stage-{{ $stage->id }}">
    <span class="pull-right">
        <a href="{{ route('settings.stages.edit', $stage->id) }}" data-toggle="ajaxModal" data-dismiss="modal">
            @icon('solid/pencil-alt', 'text-gray-500 fa-fw m-r-xs')
        </a>
        <a href="#" class="deleteStage" data-stage-id="{{ $stage->id }}">
            @icon('solid/times', 'text-gray-500 fa-fw')
        </a>
    </span>

    <span class="pull-left media-xs">@icon('solid/arrows-alt', 'mr-1 text-indigo-500')</span>

    <div class="clear">{{ $stage->name }}
        @if($stage->module === 'deals')
        <span class="badge bg-info">{{ $stage->AsPipeline()->name }}</span>
        @endif
    </div>
</li>