<section class="panel panel-default">

    <header class="clearfix bg-white header b-b">
        <div class="row m-t-sm">
            <div class="col-sm-12 m-b-xs">


                @can('milestones_update')
                <a href="{{ route('milestones.edit', $milestone->id) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                    @icon('solid/pencil-alt') @langapp('edit')
                </a>
                @endcan

                @can('milestones_delete')
                <a href="{{ route('milestones.delete', $milestone->id) }}" data-toggle="ajaxModal" title="@langapp('delete')  "
                    class="btn {{themeButton()}}">@icon('solid/trash-alt')
                    @langapp('delete')
                </a>
                @endcan

            </div>
        </div>
    </header>
    <div class="panel-body">

        <div class="col-md-6">

            <section class="panel panel-default">
                <header class="panel-heading">@icon('solid/info-circle') @langapp('milestone') </header>
                <div class="panel-body">

                    <div class="py-2">
                        <span class="text-sm text-gray-600 uppercase">@langapp('milestone_name') </span> :
                        <span class="{{themeText('font-semibold')}}">{{ $milestone->milestone_name }}</span>
                    </div>

                    <div class="py-2">
                        <span class="text-sm text-gray-600 uppercase">@langapp('project') </span> :
                        <span class="font-semibold text-gray-800">{{ $project->name }}</span>
                    </div>

                    <div class="inline pull-right">
                        <div class="easypiechart text-success" data-percent="{{ $milestone->progress }}" data-line-width="5" data-track-Color="#f0f0f0"
                            data-bar-color="{{ get_option('chart_color') }}" data-rotate="270" data-scale-Color="false" data-size="70" data-animate="2000">
                            <span class="small text-muted">{{ $milestone->progress }}%</span>
                        </div>
                    </div>

                    <div class="py-2">
                        <span class="text-sm text-gray-600 uppercase">@langapp('start_date') </span> :
                        <span class="font-semibold text-gray-800">{{ $milestone->start_date->toDayDateTimeString() }}</span>
                    </div>

                    <div class="py-2">
                        <span class="text-sm text-gray-600 uppercase">@langapp('due_date') </span> :
                        <span class="font-semibold text-gray-800">
                            {{ $milestone->due_date->toDayDateTimeString() }}
                            {!! $milestone->due_date < now() ? '<span class="text-red-500">' .langapp('overdue').'</span>' : '' !!} </span> </div> <div class="py-1">

                    </div>

                    <div class="py-1">
                        <div class="text-sm text-gray-600 uppercase">@langapp('description') </div>
                        <div class="text-sm prose-lg">
                            @parsedown($milestone->description)
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-6">

            <section class="bg-indigo-100 rounded-sm panel">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">
                        <div>
                            <span class="text-lg">@icon('solid/tasks') @langapp('tasks')</span>
                        </div>
                        <div>
                            @if (can('tasks_create') || $project->isTeam())
                            <a href="{{  route('tasks.create', ['project' => $milestone->project_id, 'milestone' => $milestone->id])  }}" data-toggle="ajaxModal"
                                class="btn {{themeButton()}} pull-right">
                                @icon('solid/plus') @langapp('create')
                            </a>
                            @endif
                        </div>
                    </div>
                </header>
                <div class="panel-body">

                    <ul class="list-group alt">
                        @foreach ($milestone->tasks as $key => $task)
                        <li class="list-group-item">
                            <div class="media">
                                <span class="pull-left thumb-sm">
                                    <img src="{{ $task->user->profile->photo }}" title="{{ $task->user->name }}" data-toggle="tooltip" class="img-circle">
                                </span>
                                <div class="pull-right text-danger m-t-sm">
                                    <span class="small text-muted">[{{ secToHours($task->time) }}]</span>
                                    <span class="task_complete">
                                        <label>
                                            <input type="checkbox" name="visible" data-id="{{ $task->id }}" {{ $task->timerRunning() ? 'disabled' : '' }}
                                                {{ $task->progress === 100 ? 'checked' : '' }}>
                                            <span class="label-text"></span>
                                        </label>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <div>
                                        <a class="{{themeText('font-semibold')}}"
                                            href="{{ route('projects.view', ['project' => $task->project_id, 'tab' => 'tasks', 'item' => $task->id]) }}">
                                            {{ $task->name }}
                                        </a>
                                    </div>
                                    <small class="text-muted">
                                        {{ dateElapsed($task->due_date) }}
                                        <span class="font-semibold text-blue-500">
                                            [{{ $task->progress }}%]
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>



                </div>
            </section>

        </div>


    </div>


</section>

@push('pagescript')
@include('tasks::_ajax.done')
@endpush