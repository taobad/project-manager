@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">

        <section class="vbox">
            <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                <div class="flex justify-between text-gray-500">
                    <div>
                        @can('expenses_update')
                        <a class="btn {{themeButton()}}" data-toggle="ajaxModal" href="{{route('expenses.edit', $expense->id)}}" title="@langapp('make_changes')"
                            data-rel="tooltip">
                            @icon('solid/pencil-alt') @langapp('edit')
                        </a>
                        @endcan
                        @can('expenses_create')
                        <a class="btn {{themeButton()}}" data-toggle="ajaxModal" href="{{route('expenses.copy', $expense->id)}}" title="{{langapp('copy')}}">
                            @icon('solid/copy') @langapp('copy')
                        </a>
                        @endcan
                        @can('expenses_update')
                        @if ($expense->is_visible == 0)
                        <a class="btn {{themeButton()}}" data-placement="bottom" title="@langapp('show_to_client')" data-toggle="tooltip"
                            href="{{route('expenses.show', $expense->id)}}">
                            @icon('solid/eye')
                        </a>
                        @else
                        <a class="btn {{themeButton()}}" data-placement="bottom" title="@langapp('hide_to_client')" data-toggle="tooltip"
                            href="{{route('expenses.hide', $expense->id)}}">
                            @icon('solid/eye-slash')
                        </a>
                        @endif
                        @endcan

                    </div>
                    <div>
                        @can('reminders_create')
                        <a class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip" data-placement="bottom"
                            href="{{route('calendar.reminder', ['module' => 'expenses', 'id' => $expense->id])}}" title="@langapp('set_reminder')">
                            @icon('solid/clock')
                        </a>
                        @endcan
                        @can('expenses_delete')
                        <a class="btn {{themeButton()}}" data-toggle="ajaxModal" href="{{ route('expenses.delete', $expense->id) }}">
                            @icon('solid/trash-alt')
                            @langapp('delete')
                        </a>
                        @endcan

                    </div>
                </div>
            </header>


            <section class="scrollable wrapper bg">
                <div class="column content-column">
                    <div class="details-page expense-margin">
                        <div class="clearfix details-container m-t-10">
                            @if($expense->is_visible === 0)
                            <x-alert type="warning" icon="regular/eye-slash" class="text-sm leading-5">
                                @langapp('expense_hidden_from_client', ['code' => $expense->code])
                            </x-alert>
                            @endif
                            <div class="row">
                                <div class="col-md-5 b-r">
                                    <div class="my-3 text-center">
                                        <span class="uppercase">
                                            @if (optional($expense->AsProject)->id > 0)
                                            @langapp('project') :
                                            <a class="{{themeLinks('font-semibold')}}" href="{{route('projects.view', ['project' => $expense->project_id])}}">
                                                {{$expense->AsProject->name}}
                                            </a>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="{{themeBg()}} pull-right rounded-lg text-white w-40 h-24 px-2 py-2 text-center">
                                        <div class="">
                                            <div class="font-semibold uppercase">
                                                @langapp('total')
                                            </div>
                                            <div class="text-lg font-semibold" data-toggle="tooltip" title="Amount after tax">
                                                {{ formatCurrency($expense->currency, $expense->amount)}}
                                                @if ($expense->is_recurring)
                                                @icon('solid/sync-alt', 'fa-2x fa-spin')
                                                @endif
                                            </div>

                                        </div>
                                    </div>

                                    <div class="m-b-sm">
                                        {{langapp('code')}}: <strong>{{ $expense->code }}</strong>
                                    </div>
                                    <div class="m-b-sm">
                                        @langapp('before_tax') : <strong data-rel="tooltip"
                                            title="Amount before tax">{{ formatCurrency($expense->currency, $expense->cost) }}</strong>
                                    </div>
                                    @if($expense->currency != 'USD')
                                    <div class="m-b-sm">
                                        @langapp('xrate') : <strong>1 USD = {{ $expense->currency }}
                                            {{$expense->exchange_rate}}</strong>
                                    </div>
                                    @endif
                                    <div class="m-b-sm">
                                        @langapp('expense_date') :
                                        <strong>{{ dateString($expense->expense_date) }}</strong>
                                    </div>
                                    <div class="m-b-sm">
                                        @langapp('category') : <strong>{{ $expense->AsCategory->name }}</strong>
                                    </div>


                                    <div class="m-b-sm">
                                        {{langapp('vendor')}} : <strong>{{$expense->vendor }}</strong>
                                    </div>
                                    @if(can('projects_view_clients') && $expense->client_id > 0)
                                    <div class="m-b-sm">
                                        @langapp('client') : <strong>
                                            <a href="{{route('clients.view', ['client' => $expense->client_id])}}">
                                                {{ $expense->company->name }}
                                            </a>
                                        </strong>
                                    </div>
                                    @endif
                                    <div class="m-b-sm">
                                        @langapp('user') :
                                        <strong>
                                            {{ $expense->user->name }}
                                        </strong>
                                    </div>
                                    <div class="m-b-sm">
                                        @langapp('billable') :
                                        <strong>
                                            {!! $expense->billable ? '<span class="label label-success">Yes</span>' : '
                                            <span class="label label-danger">
                                                No
                                            </span>' !!}
                                        </strong>
                                    </div>
                                    <div class="m-b-sm">
                                        @langapp('invoiced') :
                                        <strong>
                                            {!! $expense->invoiced ? '<span class="label label-success">Yes</span>'
                                            : '<span class="label label-danger">No</span>' !!}
                                        </strong>
                                    </div>
                                    <div class="m-b-sm">
                                        {{get_option('tax1Label')}} :
                                        <strong>{{ formatCurrency($expense->currency, $expense->tax1Amount()) }}</strong>
                                        <small>({{ $expense->tax }}%)</small>
                                    </div>
                                    <div class="m-b-sm">
                                        {{get_option('tax2Label')}} :
                                        <strong>{{formatCurrency($expense->currency, $expense->tax2Amount())}}</strong>
                                        <small>({{ $expense->tax2 }}%)</small>
                                    </div>
                                    <div class="m-b-sm">
                                        @langapp('show_to_client') :
                                        <strong>{{ $expense->is_visible ? langapp('yes') : langapp('no') }}</strong>
                                    </div>
                                    @if ($expense->invoiced_id > 0)
                                    <div class="m-b-sm">
                                        @langapp('invoiced_in') :
                                        <strong>
                                            <a href="{{ route('invoices.view', ['invoice' => $expense->invoiced_id]) }}">
                                                #{{ $expense->AsInvoice->reference_no }}
                                            </a>
                                        </strong>
                                    </div>
                                    @endif
                                    @if ($expense->is_recurring)
                                    <div class="m-b-sm">
                                        @langapp('recur_frequency') :
                                        <strong>
                                            {{$expense->recurring->frequency}} Days
                                        </strong>
                                    </div>
                                    <div class="m-b-sm">
                                        @langapp('recur_next_date') :
                                        <strong>
                                            {{ dateTimeFormatted($expense->recurring->next_recur_date) }}
                                        </strong>
                                    </div>
                                    <div class="m-b-sm">
                                        @langapp('end_date') :
                                        <strong>
                                            {{dateTimeFormatted($expense->recurring->recur_ends)}}
                                        </strong>
                                    </div>
                                    @endif
                                    <h4 class="mt-2 text-lg text-gray-500 uppercase">
                                        @langapp('notes')
                                    </h4>
                                    <div class="text-sm text-gray-600">
                                        @parsedown($expense->notes)
                                    </div>


                                    <div class="line"></div>
                                    <span class="mt-2 text-lg text-gray-500 uppercase">@langapp('tags')</span>
                                    <div class="m-1">
                                        @php
                                        $data['tags'] = $expense->tags;
                                        @endphp
                                        @include('partial.tags', $data)
                                    </div>

                                    @widget('CustomFields\Extras', ['custom' => $expense->custom])

                                    @admin
                                    <div class="line"></div>
                                    <span class="text-gray-600 uppercase">@langapp('todo')</span>
                                    <div class="m-xs">
                                        <article class="chat-item" id="chat-form">
                                            <a class="pull-left thumb-sm avatar">
                                                <img src="{{ avatar() }}" class="img-circle">
                                            </a>
                                            <section class="chat-body">
                                                {!! Form::open(['route' => 'todos.api.save', 'id' => 'createTodo',
                                                'class' => 'm-b-none']) !!}

                                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                                <input type="hidden" name="assignee" value="{{ Auth::id() }}">
                                                <input type="hidden" name="module_id" value="{{ $expense->id }}">
                                                <input type="hidden" name="module" value="expenses">
                                                <input type="hidden" name="url" value="{{ url()->previous() }}">
                                                <input type="hidden" name="json" value="false">
                                                <input type="hidden" name="due_date" value="{{ now()->addDays(7)->format(config('system.preferred_date_format'). ' h:i A') }}">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="subject" placeholder="Add a new todo...">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-info formSaving submit" type="submit">
                                                            @icon('solid/check-circle') @langapp('save')</button>
                                                    </span>
                                                </div>
                                                {!! Form::close() !!}
                                            </section>
                                        </article>
                                    </div>


                                    <div class="sortable">
                                        <div class="todo-list" id="nestable">
                                            @widget('Todos\ShowTodos', ['todos' => $expense->todos()->where(function
                                            ($query) {
                                            $query->where('user_id', Auth::id())->orWhere('assignee', Auth::id());
                                            })->get()])

                                        </div>
                                    </div>
                                    @endadmin
                                    <section class="panel panel-default">
                                        <header class="panel-heading">@langapp('activities')</header>
                                        <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="500px" data-size="3px">
                                            @widget('Activities\Feed', ['activities' => $expense->activities])
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-7">
                                    @include('partial._show_files', ['files' => $expense->files, 'limit' => true])
                                    <div class="m-xs"></div>
                                    <section class="block comment-list">
                                        <article class="comment-item" id="comment-form">
                                            <a class="pull-left thumb-sm avatar">
                                                <img src="{{ avatar() }}" class="img-circle">
                                            </a>
                                            <span class="arrow left"></span>
                                            <section class="comment-body">
                                                <section class="p-2 panel panel-default">
                                                    @widget('Comments\CreateWidget', ['commentable_type' => 'expenses', 'commentable_id' => $expense->id])
                                                </section>
                                            </section>
                                        </article>

                                        @widget('Comments\ShowComments', ['comments' => $expense->comments])
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </section>
    </section>
    <a class="hide nav-off-screen-block" data-target="#nav" data-toggle="class:nav-off-screen" href="#">
    </a>
</section>
@push('pagestyle')
<link rel=stylesheet href="{{ getAsset('plugins/nestable/nestable.css') }}">
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.wysiwyg')
@include('comments::_ajax.ajaxify')
@include('todos::_ajax.todojs')
@endpush
@endsection