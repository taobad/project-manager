<section class="panel panel-default">
    @if ($task->project_id == $project->id)
    <header class="clearfix bg-white header b-b">
        <div class="col-sm-12 m-b-xs m-t-sm">
            @if ($task->progress < 100 && $isTeam) @if ($task->timerRunning())
                <a class="btn {{themeButton()}}" href="{{route('clock.stop', ['id' => $task->id, 'module' => 'tasks'])}}">
                    @icon('solid/sync-alt','fa-spin fa-lg') @langapp('stop')
                </a>
                @else
                @can('timer_start')
                <a class="btn {{themeButton()}}" href="{{route('clock.start', ['id' => $task->id, 'module' => 'tasks'])}}">
                    @icon('solid/play') @langapp('start')
                </a>
                @endcan

                @endif
                @endif
                @can('reminders_create')
                <a href="{{ route('calendar.reminder', ['module' => 'tasks', 'id' => $task->id]) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip"
                    data-placement="bottom" title="@langapp('set_reminder')">
                    @icon('solid/clock')
                </a>
                @endcan
                @if (can('tasks_update') && ($task->user_id == \Auth::id() || $isTeam || isAdmin()))
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                    @icon('solid/pencil-alt') @langapp('edit')
                </a>
                @endif
                <div class="btn-group btn-group-animated">
                    <button type="button" class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        @icon('solid/ellipsis-h')
                    </button>
                    <ul class="dropdown-menu">
                        @if ($task->progress < 100 && $isTeam || can('tasks_complete')) <li>
                            <a href="{{ route('tasks.close', $task->id) }}">
                                @icon('solid/check-circle') @langapp('mark_as_complete')
                            </a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ route('files.upload', ['module' => 'tasks', 'id' => $task->id]) }}" data-toggle="ajaxModal">
                                    @icon('solid/upload') @langapp('upload_file')
                                </a>
                            </li>
                            @if(can('tasks_update') || $task->user_id == \Auth::id())
                            <li>
                                <a href="{{ route('users.pin', ['entity' => $task->id, 'module' => 'tasks']) }}">
                                    @icon('solid/bookmark') @langapp('pin_sidebar')
                                </a>
                            </li>
                            @endif
                            @if (can('tasks_create'))
                            <li>
                                <a href="{{ route('tasks.copy', $task->id) }}" data-toggle="ajaxModal">
                                    @icon('solid/copy') @langapp('copy')
                                </a>
                            </li>
                            @endif



                    </ul>
                </div>
                @if (can('tasks_delete') || $task->user_id == \Auth::id())
                <a href="{{route('tasks.delete', $task->id)}}" data-toggle="ajaxModal" title="@langapp('delete')" class="btn {{themeButton()}} pull-right">
                    @icon('solid/trash-alt') @langapp('delete')
                </a>
                @endif

        </div>
    </header>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">

                    <aside class="col-lg-4 lg:border-r lg:border-gray-200">
                        <section class="scrollable">
                            <div class="clearfix m-b">
                                <a href="#" class="pull-left thumb m-r">
                                    <img src="{{ $task->user->profile->photo }}" class="img-circle" data-toggle="tooltip" data-title="{{ $task->user->name}}"
                                        data-placement="right">
                                </a>
                                <div class="clear">
                                    <div class="my-1 text-2xl">{{ $task->user->name }}</div>

                                    @icon('solid/info-circle', 'text-gray-600') {{ $task->name }}

                                </div>
                            </div>
                            @if ($task->is_recurring)
                            <div class="alert alert-danger hidden-print">
                                @icon('solid/calendar-alt') This task will recur on
                                {{ dateFormatted($task->recurring->next_recur_date) }}
                            </div>
                            @endif

                            <div class="panel wrapper panel-success">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a href="#">
                                            <span class="block text-gray-500 uppercase m-b-xs">@langapp('total_time')
                                            </span>
                                            <div class="font-semibold ">{{ secToHours($task->total_time) }}</div>
                                        </a>
                                    </div>
                                    <div class="col-xs-6">
                                        <a href="#">
                                            <span class="block text-gray-500 uppercase m-b-xs">@langapp('estimated_hours')
                                            </span>
                                            <div class="font-semibold">{{ $task->estimated_hours }} @langapp('hours')
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-{{get_option('theme_color') }}" data-toggle="tooltip" data-original-title="{{$task->progress}}%"
                                    style="width: {{ $task->progress }}%"></div>
                            </div>
                            <div class="text-gray-500 uppercase">
                                @langapp('hourly_rate')
                            </div>
                            <div class="my-2 text-dark">{{ $task->hourly_rate }}/ hr</div>
                            <div class="text-gray-500 uppercase">@langapp('estimated_price')</div>
                            <div class="my-2 text-dark">{{ $task->est_price }}</div>
                            <div>
                                @if ($task->milestone_id > 0)
                                <div class="text-gray-500 uppercase">@langapp('milestone') </div>
                                <div class="py-2">
                                    <a class="font-semibold text-indigo-600"
                                        href="{{route('projects.view', ['project' => $task->project_id, 'tab' => 'milestones', 'item' => $task->milestone_id])}}">
                                        {{optional($task->AsMilestone)->milestone_name}}
                                    </a>
                                </div>
                                @endif
                                <div class="text-gray-500 uppercase">@langapp('start_date')</div>
                                <div class="py-1">
                                    <div class="py-2">
                                        <span class="font-semibold text-indigo-500">
                                            {{$task->start_date->toDayDateTimeString()}}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-gray-500 uppercase">@langapp('end_date')</div>
                                <div class="py-2">
                                    <span class="font-semibold text-red-500">
                                        {{$task->due_date->toDayDateTimeString()}}
                                    </span>
                                </div>

                                <div class="text-gray-500 uppercase">@langapp('created_at')</div>
                                <div class="py-2">
                                    <span class="">
                                        {{$task->created_at->toDayDateTimeString()}}
                                    </span>
                                </div>

                                <div class="text-gray-500 uppercase">@langapp('description') </div>

                                <div class="text-sm prose-lg">
                                    @parsedown($task->description)
                                </div>

                                @if ($project->isTeam() || can('projects_view_team'))
                                <div class="line"></div>

                                <div class="text-gray-500 uppercase">@langapp('users')</div>


                                <ul class="list-unstyled team-info m-sm">
                                    @foreach ($task->assignees as $assignee)
                                    <li>
                                        <img src="{{ $assignee->user->profile->photo}}" data-toggle="tooltip" data-title="{{$assignee->user->name  }}" data-placement="top">
                                    </li>
                                    @endforeach
                                </ul>


                                @endif

                                @if($isTeam || isAdmin())
                                <div class="line"></div>
                                <div class="text-gray-500 uppercase">@langapp('tags')</div>

                                @php
                                $data['tags'] = $task->tags;
                                @endphp
                                @include('partial.tags', $data)

                                @endif
                                <div class="py-2 text-gray-500 uppercase">
                                    @langapp('vaults')
                                    <a href="{{ route('extras.vaults.create', ['module' => 'tasks', 'id' => $task->id]) }}" class="btn {{themeButton()}} pull-right"
                                        data-toggle="ajaxModal">
                                        @icon('solid/plus')
                                    </a>
                                </div>
                                <div class="line"></div>
                                @widget('Vaults\Show', ['vaults' => $task->vault])
                                <div class="text-gray-500 uppercase">@langapp('files') </div>
                                @include('partial._show_files', ['files' => $task->files, 'limit' => true])


                            </div>
                        </section>
                    </aside>
                    <aside class="col-lg-8">
                        <section class="scrollable">
                            <div id="tabs">
                                <ul class="nav nav-tabs" id="prodTabs">
                                    <li class="active">
                                        <a href="#tab_comments">
                                            @langapp('comments')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab_todos" data-url="/tasks/ajax/todos/{{ $task->id }}">
                                            @langapp('checklist') ({{ $task->todoCompleted() }}%)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab_timesheets" data-url="/tasks/ajax/timesheets/{{ $task->id }}">
                                            @langapp('timesheets')
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab_comments" class="tab-pane active">
                                        <section class="block comment-list">
                                            <article class="comment-item" id="comment-form">
                                                <a class="pull-left thumb-sm avatar">
                                                    <img src="{{ avatar() }}" class="img-circle">
                                                </a>
                                                <span class="arrow left"></span>
                                                <section class="comment-body">
                                                    <section class="p-2 panel panel-default">
                                                        @widget('Comments\CreateWidget', ['commentable_type' => 'tasks', 'commentable_id' => $task->id, 'hasFiles' => true])
                                                    </section>
                                                </section>
                                            </article>
                                            @widget('Comments\ShowComments', ['comments' => $task->comments])
                                        </section>
                                    </div>
                                    <div id="tab_todos" class="tab-pane active"></div>
                                    <div id="tab_timesheets" class="tab-pane active"></div>
                                </div>
                            </div>


                        </section>
                    </aside>
                    @endif

                </div>
            </section>
        </div>
    </div>

    @push('pagestyle')
    @include('stacks.css.wysiwyg')
    @endpush
    @push('pagescript')
    @include('stacks.js.wysiwyg')
    @include('comments::_ajax.ajaxify')
    <script>
        $('#tabs').on('click','.tablink,#prodTabs a',function (e) {
        e.preventDefault();
        var url = $(this).attr("data-url");
        if (typeof url !== "undefined") {
            var pane = $(this), href = this.hash;
        $(href).load(url,function(result){
            pane.tab('show');
        });
        } else {
            $(this).tab('show');
        }
    });
    </script>
    @endpush