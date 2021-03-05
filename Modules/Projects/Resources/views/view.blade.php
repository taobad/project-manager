@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <aside class="b-l">
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">
                        <div>
                            <span class="text-xl font-semibold text-gray-500">{{$project->name }}</span>
                            @if ($project->isOverdue())
                            <span class="px-1 py-1 ml-2 text-white bg-red-400 rounded-sm">@langapp('overdue')</span>
                            @endif
                        </div>
                        <div>

                            @if ($project->isTeam() || isAdmin())
                            <a href="{{ route('timetracking.create', ['module' => 'projects', 'id' => $project->id])}}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                                @icon('solid/history') @langapp('time_entry')
                            </a>
                            @endif

                            @can('projects_update')
                            @php
                            $txt = $project->auto_progress ? 'auto_progress_off' : 'auto_progress_on';
                            @endphp
                            <a href="{{ route('projects.autoprogress', $project->id) }}" data-toggle="tooltip" title="@langapp($txt)" data-placement="bottom"
                                class="btn {{themeButton()}}">
                                @icon('solid/plane')
                            </a>
                            @endcan

                            @can('timer_start')

                            @if ($project->timer_on)
                            <a data-toggle="tooltip" data-original-title="@langapp('stop_timer')" data-placement="bottom"
                                href="{{ route('clock.stop', ['id' => $project->id, 'module' => 'projects'])}}" class="btn {{themeButton()}}">
                                @icon('solid/sync-alt', 'fa-spin text-danger hover:text-white')
                            </a>
                            @else
                            <a data-toggle="tooltip" data-original-title="@langapp('start_timer')" data-placement="bottom"
                                href="{{ route('clock.start', ['id' => $project->id, 'module' => 'projects'])}}" class="btn {{themeButton()}}">
                                @icon('solid/stopwatch')
                            </a>
                            @endif
                            @endcan
                            <a data-rel="tooltip" title="@langapp('pin_sidebar')" data-placement="bottom"
                                href="{{ route('users.pin', ['entity' => $project->id, 'module' => 'projects']) }}" class="btn {{themeButton()}}">
                                @icon('solid/bookmark')
                            </a>

                            @if ($project->is_template && isAdmin())
                            <a href="{{ route('projects.fromtemplate', $project->id) }}" data-toggle="ajaxModal" title="@langapp('create_from_template')" data-rel="tooltip"
                                class="btn {{themeButton()}}">
                                @icon('solid/recycle') @langapp('use_template')
                            </a>
                            @endif




                            <div class="btn-group btn-group-animated pull-right dropdown">
                                <button type="button" class="btn {{themeButton()}} dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    @icon('solid/ellipsis-h')
                                </button>

                                <ul class="dropdown-menu">
                                    @if ($project->client_id > 0)
                                    @can('invoices_create')
                                    <li>
                                        <a href="{{ route('projects.invoice', $project->id)}}" data-toggle="ajaxModal" data-rel="tooltip" title="@langapp('invoice')">
                                            @icon('solid/file-invoice-dollar') @langapp('invoice')
                                        </a>
                                    </li>
                                    @endcan
                                    @endif
                                    @can('reminders_create')
                                    <li>
                                        <a href="{{ route('calendar.reminder', ['module' => 'projects', 'id' => $project->id]) }}" data-toggle="ajaxModal">
                                            @icon('solid/clock') @langapp('reminder')
                                        </a>
                                    </li>
                                    @endcan

                                    @can('projects_copy')
                                    <li>
                                        <a href="{{ route('projects.copy', $project->id) }}" data-toggle="ajaxModal">
                                            @icon('solid/copy') @langapp('copy')
                                        </a>
                                    </li>
                                    @endcan
                                    @can('projects_update')
                                    <li>
                                        <a href="{{ route('projects.edit', $project->id) }}" data-toggle="tooltip" title="@langapp('make_changes')">
                                            @icon('solid/pencil-alt') @langapp('edit')
                                        </a>
                                    </li>
                                    @endcan
                                    @if(isAdmin() || $project->setting('show_project_links') || $project->isTeam())
                                    <li>
                                        <a href="{{ route('projects.view', ['project' => $project->id, 'tab' => 'links'])}}">
                                            @icon('solid/link') @langapp('links')
                                        </a>
                                    </li>
                                    @endif
                                    @if($project->client_id > 0 && (isAdmin() || can('projects_download')))
                                    <li>
                                        <a href="{{ route('projects.export', $project->id)}}">
                                            @icon('regular/file-pdf') PDF
                                        </a>
                                    </li>
                                    @endif
                                    @admin
                                    @if(optional($project->company)->primary_contact)
                                    <li>
                                        <a href="{{ route('users.impersonate', $project->company->contact->id) }}">
                                            @icon('solid/user-secret') As Client
                                        </a>
                                    </li>
                                    @endif
                                    @endadmin

                                    @if ($project->auto_progress && $project->manager == \Auth::id())
                                    <li>
                                        <a data-toggle="ajaxModal" data-rel="tooltip" title="@langapp('mark_as_complete')" href="{{ route('projects.done', $project->id) }}">
                                            @icon('solid/check-square') @langapp('done')
                                        </a>
                                    </li>
                                    @endif
                                    @can('projects_delete')
                                    <li>
                                        <a href="{{ route('projects.delete', $project->id)}}" data-toggle="ajaxModal" data-rel="tooltip" title="@langapp('delete')">
                                            @icon('solid/trash-alt') @langapp('delete')
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>



                        </div>
                    </div>
                </header>
                <header class="clearfix bg-white header b-b">
                    <div class="row m-t-sm">
                        <div class="col-sm-6">
                            <h4 class="m-t-sm pull-left">

                            </h4>
                        </div>
                        <div class="col-sm-6">


                        </div>
                    </div>
                </header>

                <section class="p-2 bg-indigo-100 scrollable wrapper scrollpane">

                    <div class="p-4 bg-white rounded-sm col-md-12">

                        <div class="ribbon {{$project->ribbonColor()}}"><span>{{$project->status}}</span></div>


                        <div class="sub-tab m-b-10">
                            <ul class="nav pro-nav-tabs nav-tabs-dashed">
                                @foreach (projectMenu() as $menu)
                                @php $perm = true; @endphp
                                @if ($menu->permission != '')
                                @php $perm = $project->setting($menu->permission); @endphp
                                @endif
                                @if ($perm)
                                @php $timer_on = 0; @endphp
                                @if ($menu->module == 'project_timesheets')
                                @php
                                $timer_on = $project->timesheets()->running()->count();
                                @endphp
                                @endif
                                @endif
                                <li class="{{ $tab == $menu->route ? 'active font-bold' : ''}}">
                                    <a class="text-xs text-gray-600 uppercase" href="{{ route('projects.view', ['project' => $project->id, 'tab' => $menu->route])}}">
                                        @langapp($menu->route)
                                        @if ($timer_on > 0)
                                        <span class="m-r-xs">@icon('solid/sync-alt', 'fa-spin text-danger')</span>
                                        @endif
                                    </a>
                                </li>

                                @endforeach
                            </ul>
                        </div>

                        @include('projects::tab._'.$tab)

                    </div>


                </section>
            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>
@endsection