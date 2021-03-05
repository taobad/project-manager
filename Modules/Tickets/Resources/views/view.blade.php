@extends('layouts.app')
@section('content')
@php
$ticket->is_locked ? $ticket->releaseTicket() : '';
$isAgent = $ticket->isAgent();
@endphp
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="clearfix bg-white header b-b hidden-print">
                    <div class="col-md-12 m-t-sm">
                        @can('reminders_create')
                        <a class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip" data-placement="bottom"
                            href="{{route('calendar.reminder', ['module' => 'tickets', 'id' => $ticket->id])}}" title="@langapp('set_reminder')">
                            @icon('solid/clock')
                        </a>
                        @endcan

                        @if (isAdmin() || $isAgent)
                        <a href="{{route('tickets.edit', $ticket->id)}}" data-toggle="tooltip" title="@langapp('edit')" class="btn {{themeButton()}}" data-placement="bottom">
                            @icon('solid/pencil-alt')
                        </a>
                        @endif
                        @if (isAdmin() || $isAgent)
                        <a href="{{route('tickets.convert', $ticket->id)}}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                            @icon('solid/check-circle') @langapp('convert_to_task')
                        </a>
                        @endif
                        <div class="btn-group">
                            <button class="btn {{themeButton()}} dropdown-toggle" data-toggle="dropdown">@langapp('status')
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach (App\Entities\Status::select('id', 'status')->get() as $key => $status)
                                @if($status->id != $ticket->status)
                                <li>
                                    <a href="{{ route('tickets.status', ['ticket' => $ticket->id, 'status' => $status->id])}}" data-toggle="ajaxModal">
                                        @langapp($status->status)
                                    </a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        @if (isAdmin() || $isAgent)
                        @if($ticket->rated)
                        <a href="{{ route('tickets.reviews', $ticket->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                            @icon('solid/star') @langapp('reviews')
                        </a>
                        @endif
                        @endif
                        @if (isAdmin() || can('tickets_delete'))
                        <a href="#aside-todos" data-toggle="class:show" class="btn {{themeButton()}} pull-right">@icon('solid/chevron-right')</a>

                        <a href="{{route('tickets.delete', $ticket->id)}}" class="btn {{themeButton()}} pull-right" data-toggle="ajaxModal">
                            @svg('solid/trash-alt') @langapp('delete')
                        </a>
                        @endif

                    </div>
                </header>
                <section class="bg-indigo-100 scrollable">

                    <div class="wrapper">

                        <div class="rows">
                            <section class="">

                                <div class="col-md-4">
                                    @if (isAdmin() || $isAgent)

                                    <section class="panel panel-default">
                                        <header class="panel-heading">@langapp('make_changes') </header>
                                        <div class="panel-body">
                                            {!! Form::open(['route' => ['tickets.api.update', $ticket->id], 'class' => 'ajaxifyForm', 'method' => 'PUT', 'data-toggle' =>
                                            'validator']) !!}
                                            <input type="hidden" name="id" value="{{ $ticket->id }}">
                                            <input type="hidden" name="subject" value="{{ $ticket->subject }}">
                                            <div class="form-group">
                                                <label>@langapp('code')</label>
                                                <input type="text" class="form-control" value="{{ $ticket->code }}" readonly="readonly">
                                            </div>
                                            <div class="form-group">
                                                <label>@langapp('created_at')</label>
                                                <input type="text" class="form-control" value="{{ dateTimeFormatted($ticket->created_at) }}" readonly="readonly">
                                            </div>
                                            @if (isAdmin() || can('tickets_reporter'))
                                            <div class="form-group">
                                                <label>@langapp('reporter') @required</label>
                                                <div class="m-b">
                                                    <select class="select2-option form-control" name="user_id">
                                                        @foreach (app('user')->select('id', 'username', 'name')->offHoliday()->get() as $user)
                                                        <option value="{{ $user->id }}" {{ $ticket->user_id == $user->id ? ' selected' : ''}}>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <label>@langapp('project')</label>
                                                <select class="select2-option form-control" name="project_id" required>
                                                    <option value="0">None</option>
                                                    @if(isAdmin())
                                                    @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}" {{ $project->id == $ticket->project_id ? 'selected' : '' }}>{{ $project->name }}</option>
                                                    @endforeach
                                                    @else
                                                    @foreach (Auth::user()->assignments()->where('assignable_type', Modules\Projects\Entities\Project::class)->get() as $entity)
                                                    <option value="{{ $entity->assignable->id }}" {{ $entity->assignable->id == $ticket->project_id ? 'selected' : '' }}>
                                                        {{ $entity->assignable->name }}</option>
                                                    @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>@langapp('department') @required</label>
                                                <div class="m-b">
                                                    <select name="department" class="form-control">
                                                        @foreach (App\Entities\Department::all() as $d)
                                                        <option value="{{ $d->deptid }}" {{ $ticket->department === $d->deptid ? ' selected' : '' }}>{{ucfirst($d->deptname)}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>@langapp('assigned')</label>
                                                <div class="m-b">
                                                    <select name="assignee" class="form-control">
                                                        @foreach (Modules\Users\Entities\User::role('admin')->get() as $admin)
                                                        <option value="{{ $admin->id }}" {{ $admin->id == $ticket->assignee ? 'selected' : '' }}>
                                                            {{ $admin->name }}
                                                        </option>
                                                        @endforeach
                                                        @foreach (Modules\Users\Entities\UserHasDepartment::groupBy('user_id')->get() as $user)
                                                        <option value="{{ $user->user_id }}" {{ $user->user_id == $ticket->assignee ? 'selected' : '' }}>
                                                            {{ $user->user->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {!! renderAjaxButton() !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </section>
                                    @else
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right">#{{ $ticket->code }}</span>@langapp('code')
                                        </li>
                                        <li class="list-group-item">
                                            @langapp('reporter')
                                            <span class="pull-right">
                                                @if (!is_null($ticket->user_id))
                                                <a class=" thumb-xs avatar pull-left" data-toggle="tooltip" data-title="{{ $ticket->user->email}}" data-placement="right">
                                                    <img src="{{ $ticket->user->profile->photo }}" class="inline img-circle">
                                                    {{$ticket->user->name }}
                                                </a>
                                                @endif
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right">
                                                {{ $ticket->dept->deptname }}
                                            </span>@langapp('department')
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><label class="label label-default">
                                                    @langapp($ticket->AsStatus->status)</label>
                                            </span>@langapp('status')
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right">@langapp(strtolower($ticket->AsPriority->priority))</span>
                                            @langapp('priority')
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right label label-success" data-toggle="tooltip" data-title="{{$ticket->created_at}}" data-placement="left">
                                                {{dateTimeFormatted($ticket->created_at) }}
                                            </span>@langapp('created_at')
                                        </li>

                                    </ul>
                                    @endif
                                    <small class="text-uc text-muted">@icon('solid/shield-alt')
                                        @langapp('vaults')
                                        <a href="{{ route('extras.vaults.create', ['module' => 'tickets', 'id' => $ticket->id]) }}" class="btn btn-xs btn-danger pull-right"
                                            data-toggle="ajaxModal">@icon('solid/plus')</a>
                                    </small>
                                    <div class="line"></div>

                                    @widget('Vaults\Show', ['vaults' => $ticket->vault])


                                    @if (isAdmin() || $isAgent)
                                    <div class="line"></div>
                                    <small class="text-xs text-uc text-muted">@langapp('tags') </small>
                                    <div class="m-xs">
                                        @php
                                        $data['tags'] = $ticket->tags;
                                        @endphp
                                        @include('partial.tags', $data)
                                    </div>
                                    @endif

                                    <section class="panel panel-default">
                                        <header class="panel-heading">@langapp('additional_fields')</header>
                                        <div class="">
                                            <table class="table table-borderless table-xs small">
                                                <tbody>
                                                    @foreach ($ticket->custom as $field)
                                                    <tr>
                                                        <td>{{ucfirst(humanize($field->meta_key, '-'))}}</td>
                                                        <td class="text-right">
                                                            <span class="pull-right">
                                                                <span
                                                                    class="">{{ isJson($field->meta_value) ? implode(', ', json_decode($field->meta_value)) : $field->meta_value }}</span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>


                                        </div>
                                    </section>
                                    <section class="panel panel-default">
                                        <header class="panel-heading">
                                            @icon('solid/bell') @langapp('activities')
                                        </header>
                                        @widget('Activities\Feed', ['activities' => $ticket->activities])

                                    </section>
                                </div>

                                <div class="bg-white rounded-sm col-md-8">
                                    <div class="ribbon {{is_null($ticket->closed_at) ? 'info' : 'success' }}"><span>@langapp($ticket->AsStatus->status)</span></div>

                                    <div class="py-2">

                                        <header class="panel-heading">

                                            <div class="flex justify-between mt-2 text-gray-500">
                                                <div class="font-semibold text-gray-600">
                                                    {{ $ticket->subject }}
                                                </div>
                                                <div class="text-gray-600">
                                                    <a class="thumb-xs avatar">
                                                        <img src="{{ $ticket->user->profile->photo }}" class="inline-block img-circle" alt="{{ $ticket->user->name}}">
                                                    </a> <span class="align-middle">{{ $ticket->user->name }}
                                                        &laquo;{{ $ticket->user->email }}&raquo;
                                                    </span>
                                                </div>

                                                <div>
                                                    @icon('regular/clock') <span class="text-xs text-gray-600">{{ $ticket->created_at->diffForHumans() }}</span>
                                                </div>

                                            </div>



                                        </header>
                                        <div class="line line-dashed line-lg pull-in"></div>

                                        <div class="p-2 text-sm prose-lg">
                                            @parsedown($ticket->body)
                                        </div>

                                    </div>

                                    @include('partial._show_files', ['files' => $ticket->files])
                                    <div class="m-xs"></div>

                                    <div class="line line-dashed line-lg pull-in"></div>
                                    @if (is_null($ticket->closed_at))
                                    @if ($ticket->response_status == 'awaiting_agent')
                                    <x-alert type="warning" icon="regular/bell" class="mb-4 text-sm leading-5 ">
                                        Ticket awaiting reply from customer support team.
                                    </x-alert>
                                    @endif
                                    @endif

                                    @if($ticket->isLocked())
                                    <x-alert type="warning" icon="solid/exclamation-triangle" class="mt-2 mb-3 text-sm leading-5">
                                        <strong>{{ $ticket->activeAgent->name }}</strong> is working on this ticket...
                                    </x-alert>
                                    @endif


                                    <section class="block comment-list">

                                        @if(!isCommentLocked('tickets', $ticket->id))
                                        <article class="comment-item" id="comment-form">
                                            <a class="pull-left thumb-sm avatar">
                                                <img src="{{ avatar() }}" class="img-circle">
                                            </a>
                                            <span class="arrow left"></span>
                                            <section class="comment-body">
                                                <section class="p-2 panel panel-default">
                                                    @widget('Comments\CreateWidget', [
                                                    'commentable_type' => 'tickets' , 'commentable_id' => $ticket->id, 'hasFiles' => true,
                                                    'cannedResponse' => true
                                                    ])
                                                </section>
                                            </section>
                                        </article>
                                        @endif

                                        @widget('Comments\ShowComments', ['comments' => $ticket->comments])

                                    </section>
                                </div>
                            </section>
                        </div>


                    </div>

                </section>


            </section>

        </aside>

        <aside class="bg-white aside-lg b-l hide" id="aside-todos">
            <header class="bg-white header b-b b-light">
                <p>@langapp('todo')</p>
            </header>
            <div class="m-xs">
                <article class="chat-item" id="chat-form">
                    <a class="pull-left thumb-sm avatar">
                        <img src="{{ avatar() }}" class="img-circle">
                    </a>

                    <section class="chat-body">

                        {!! Form::open(['route' => 'todos.api.save', 'id' => 'createTodo', 'class' => 'm-b-none']) !!}

                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="assignee" value="{{ Auth::id() }}">
                        <input type="hidden" name="module_id" value="{{ $ticket->id }}">
                        <input type="hidden" name="module" value="tickets">
                        <input type="hidden" name="url" value="{{ url()->previous() }}">
                        <input type="hidden" name="json" value="false">
                        <input type="hidden" name="due_date" value="{{ now()->addDays(7)->format(config('system.preferred_date_format'). ' h:i A') }}">
                        <div class="input-group">
                            <input type="text" class="form-control" name="subject" placeholder="Add a new todo...">
                            <span class="input-group-btn">
                                <button class="btn btn-info formSaving submit" type="submit"> @icon('solid/check-circle') @langapp('save')</button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                    </section>
                </article>

                <div class="sortable">

                    <div class="todo-list" id="nestable">

                        @widget('Todos\ShowTodos', ['todos' => $ticket->todos()->where(function ($query) {
                        $query->where('user_id', Auth::id())->orWhere('assignee', Auth::id());
                        })->get()])

                    </div>

                </div>

            </div>

        </aside>

    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@push('pagestyle')
@include('stacks.css.form')
@include('stacks.css.wysiwyg')
<link rel=stylesheet href="{{ getAsset('plugins/nestable/nestable.css') }}">
@endpush
@push('pagescript')
@include('stacks.js.wysiwyg')
@include('stacks.js.form')
@include('todos::_ajax.todojs')
@if($isAgent)
<script>
    $( document ).ready(function() {
        @if (get_option('htmleditor') == 'easyMDE')
        $( ".CodeMirror" ).on('focusin', function() {
            ticketId = $('#{{get_option('htmleditor')}}').attr("data-id");
            lockTicket(ticketId);         
        });
        @endif
        @if (get_option('htmleditor') == 'summernoteEditor')
        $( ".note-editing-area" ).on('focusin', function() {
            ticketId = $('#{{get_option('htmleditor')}}').attr("data-id");
            lockTicket(ticketId);         
        });
        @endif
        @if (get_option('htmleditor') == 'markdownEditor')
        $( "#{{get_option('htmleditor')}}" ).on('focusin', function() {
            ticketId = $(this).attr("data-id");
            lockTicket(ticketId);         
        });
        @endif
        function lockTicket(id) {
            axios.post('{{ route('tickets.lock') }}', {
                "id": id
            })
            .then(function (response) {
            })
            .catch(function (error) {
                toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
            }); 
        }
});
</script>
@endif
@include('comments::_ajax.ajaxify')
@endpush
@endsection