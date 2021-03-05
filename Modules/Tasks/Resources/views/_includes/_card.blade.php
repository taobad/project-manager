<div class="lobilist-wrapper ps-container ps-theme-dark ps-active-y kanban-col">
    <div id="lobilist-list-0" class="bg-white lobilist lobilist-default rounded-t-md">
        <div class="bg-white lobilist-header ui-sortable-handle rounded-t-md">
            <div class="font-semibold text-gray-500 uppercase lobilist-title text-ellipsis">
                <span class="arrow right"></span> {{ $card->name }}
            </div>
        </div>
        <div class="lobilist-body scrumboard slim-scroll" data-disable-fade-out="true" data-distance="0" data-size="3px" data-height="550" data-color="#333333">
            <ul class="lobilist-items ui-sortable list" id="{{ $card->id }}">
                @php $counter = 0; @endphp
                @foreach ($project->tasks()->where('stage_id', $card->id)->with('user:id,username,name')->get() as
                $task)

                <li id="{{  $task->id  }}" draggable="true" class="lobilist-item kanban-entry grab">
                    <div class="ml-2 lobilist-item-title text-ellipsis">
                        <a class="{{themeText('font-semibold')}}" href="{{ route('projects.view', ['project' => $project->id, 'tab' => 'tasks', 'item' => $task->id]) }}"
                            class="">{{ $task->name }}</a>
                    </div>
                    <div class="text-gray-600 lobilist-item-description">
                        <span class="pull-right text-success">{!! $task->is_recurring ? '<i class="fas fa-sync fa-spin text-danger"></i>' : '' !!} {{ $task->progress }}%
                            {{ $task->progress == 100 ? '✓' : '' }}</span>

                        <span class="text-gray-600">
                            @icon('solid/stopwatch', 'text-danger')
                            {{ secToHours($task->time) }}
                        </span>
                    </div>
                    <div class="text-xs text-gray-600">
                        @ {{ $task->hourly_rate }}/hr

                        @if($task->visible)
                        <span data-toggle="tooltip" title="Visible to client">@icon('regular/lightbulb')</span>
                        @endif

                    </div>

                    <div class="text-xs text-gray-700 lobilist-item-duedate">
                        {{  dateFormatted($task->start_date) }} - {{  dateFormatted($task->due_date) }}
                    </div>
                    @if ($task->user_id > 0)
                    <span class="thumb-xs avatar lobilist-check">
                        <img src="{{ $task->user->profile->photo }}" class="img-circle" data-toggle="tooltip" title="{{ $task->user->name }}" data-placement="right">
                    </span>
                    @endif
                    <div class="todo-actions">
                        @if ($task->isOverdue())
                        <span class="label label-danger">@langapp('overdue')</span>
                        @endif

                    </div>
                    <div class="drag-handler"></div>
                </li>
                @php $counter++; @endphp
                @endforeach
            </ul>
        </div>
        <div class="lobilist-footer">
            <strong class="text-indigo-600">{{ $counter }} {{ str_plural('task', $counter) }} </strong>
        </div>
    </div>
</div>