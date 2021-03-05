<li class="list-group-item" draggable="true" id="department-{{ $department->deptid }}">
    <span class="pull-right">
        <a href="{{ route('departments.edit', $department->deptid) }}" data-toggle="ajaxModal" data-dismiss="modal">
            @icon('solid/pencil-alt', 'text-gray-700 fa-fw mr-1')
        </a>
        <a href="#" class="deleteDepartment" data-department-id="{{ $department->deptid }}">
            @icon('solid/times', 'text-gray-700 fa-fw')
        </a>
    </span>

    <span class="pull-left media-xs">@icon('solid/arrows-alt', 'mr-1')</span>

    <div class="clear">{{ $department->deptname }}</div>
</li>