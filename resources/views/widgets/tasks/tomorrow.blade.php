<div class="lobilist-wrapper ps-container ps-theme-dark ps-active-y kanban-col">
    <div id="lobilist-list-0" class="lobilist lobilist-default bg-white rounded-md">
        <div class="lobilist-header ui-sortable-handle bg-white rounded-md">
            <div class="lobilist-title text-ellipsis">
                <span class="arrow right"></span>👍 @langapp('tomorrow') - <span class="small text-gray-600"> {{ now()->tomorrow()->toFormattedDateString() }}</span>
            </div>
        </div>
        <div class="lobilist-body scrumboard slim-scroll" data-height="450" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">


            <ul class="lobilist-items ui-sortable list" id="today">
                @php $taskCounter = 0; @endphp
                @foreach (Auth::user()->tasksAssignedOpen()->whereDate('due_date', now()->tomorrow())->get() as $task)
                <li id="{{ $task->id }}" class="lobilist-item kanban-entry grab dd-item">
                    <div class="lobilist-item-title text-ellipsis ml-2">
                        <a class="text-indigo-400 font-semibold" href="{{ route('projects.view', ['project' => $task->project_id, 'tab' => 'tasks', 'item' => $task->id]) }}"
                            class="">{{ str_limit($task->name, 50) }}</a>
                    </div>
                    <div class="lobilist-item-description text-gray-600">
                        <small class="">@icon('regular/clock')
                            {{ !empty($task->due_date) ? dateElapsed($task->due_date) : '' }}
                        </small>
                        <span class="label label-success">{{ $task->progress }}%</span>
                    </div>
                    <div class="lobilist-item-duedate text-xs text-gray-700">
                        {{  dateFormatted($task->due_date) }}
                    </div>
                    <span class="thumb-xs avatar lobilist-check">
                        <img src="{{ $task->user->photo }}" data-rel="tooltip" title="{{ $task->user->name }}" data-placement="right" class="img-circle">
                    </span>


                </li>
                @php $taskCounter++; @endphp
                @endforeach
            </ul>
        </div>
        <div class="lobilist-footer">
            {{-- <strong>
            {{ Auth::user()->tasksToday()->count() }} @langapp('done')
            </strong> --}}
            <strong>
                {{ $taskCounter }} @langapp('pending')
            </strong>
        </div>
    </div>
</div>