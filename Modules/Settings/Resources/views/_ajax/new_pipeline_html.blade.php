<li class="list-group-item" draggable="true" id="pipeline-{{ $pipeline->id }}">
    <span class="pull-right">
        <a href="{{ route('settings.pipelines.edit', $pipeline->id) }}" data-toggle="ajaxModal" data-dismiss="modal">
            @icon('solid/pencil-alt', 'text-gray-600 fa-fw m-r-xs')
        </a>
        <a href="#" class="deletePipeline" data-pipeline-id="{{ $pipeline->id }}">
            @icon('solid/times', 'text-gray-600 fa-fw')
        </a>
    </span>
    <span class="pull-left media-xs">@icon('solid/arrows-alt', 'm-r-sm')</span>
    <div class="clear">{{ $pipeline->name }}</div>
</li>