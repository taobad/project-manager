@extends('layouts.app')

@section('content')
<section id="content" class="bg-indigo-100">
    <section class="vbox">
        <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
            <div class="flex justify-between text-gray-500">
                <div>
                    <div class="btn-group">
                        <button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown">@langapp('filter') <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('tickets.index', ['filter' => 'mine']) }}">@langapp('mine')</a></li>
                            <li><a href="{{ route('tickets.index', ['filter' => 'closed']) }}">@langapp('closed')</a></li>
                            <li><a href="{{ route('tickets.index', ['filter' => 'archived']) }}">@langapp('archived')</a></li>
                            <li><a href="{{ route('tickets.index') }}">@langapp('all')</a></li>
                        </ul>
                    </div>
                    <div class="ml-1 btn-group">
                        <button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown">
                            @langapp('department') <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach(App\Entities\Department::select('deptid','deptname')->get() as $dept)
                            <li>
                                <a href="{{ route('tickets.index', ['department' => $dept->deptid]) }}">
                                    {{ ucfirst($dept->deptname) }}
                                </a>
                            </li>
                            @endforeach
                            <li><a href="{{ route('tickets.index') }}">@langapp('all')</a></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <a href="{{ route('tickets.create') }}" class="btn {{themeButton()}}">
                        @icon('solid/plus') @langapp('create')
                    </a>

                    @admin
                    <a href="{{ route('departments.show') }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                        @icon('solid/layer-group')
                    </a>
                    @endadmin
                </div>
            </div>
        </header>
        <section class="scrollable wrapper">
            <section class="panel panel-default">

                @admin
                @livewire('ticket.stats-widget')
                @endadmin

                <form id="frm-ticket" method="POST">
                    <input type="hidden" name="module" value="tickets">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tickets-table">
                            <thead>
                                <tr>
                                    <th class="hide"></th>
                                    <th class="no-sort">
                                        <label>
                                            <input name="select_all" value="1" id="select-all" type="checkbox" />
                                            <span class="label-text"></span>
                                        </label>
                                    </th>
                                    <th class="">@langapp('subject')</th>
                                    @can('tickets_update')
                                    <th class="">@langapp('reporter')</th>
                                    @endcan
                                    <th class="">@langapp('priority')</th>
                                    <th class="col-date">@langapp('date')</th>
                                    <th class="">@langapp('department')</th>
                                    <th class="">@langapp('status')</th>
                                    <th class="">@langapp('due_date')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <button type="submit" value="bulk-close" class="btn {{themeButton()}} m-xs">
                        @icon('regular/check-circle') @langapp('close')
                    </button>
                    <button type="submit" value="bulk-open" class="btn {{themeButton()}} m-xs">
                        @icon('solid/exclamation-circle') @langapp('open')
                    </button>

                    @can('tickets_update')
                    <button type="submit" value="bulk-archive" class="btn {{themeButton()}} m-xs" data-rel="tooltip" title="@langapp('archive')">
                        @icon('solid/archive')
                    </button>
                    @endcan
                    @can('tickets_delete')
                    <button type="submit" value="bulk-delete" class="btn {{themeButton()}} m-xs" data-rel="tooltip" title="@langapp('delete')">
                        @icon('solid/trash-alt')
                    </button>
                    @endcan

                </form>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@push('pagestyle')
@include('stacks.css.datatables')
@endpush
@push('pagescript')
@include('stacks.js.datatables')
<script>
    $(function() {
    var table = $('#tickets-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{{ route('tickets.data') }}',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "filter": '{{ $filter }}', "department": '{{ $department }}'
        }
    },
    order: [[ 0, "desc" ]],
    columns: [
    { data: 'id', name: 'id' },
    { data: 'chk', name: 'chk', orderable: false, searchable: false, sortable: false },
    { data: 'subject', name: 'subject' },
    @can('tickets_update')
    { data: 'user', name: 'user.name' },
    @endcan
    { data: 'priority', name: 'AsPriority.priority' },
    { data: 'created_at', name: 'created_at' },
    { data: 'department', name: 'dept.deptname' },
    { data: 'status', name: 'AsStatus.status' },
    { data: 'due_date', name: 'due_date' }
    ]
    });
    $("#frm-ticket button").click(function(ev){
    ev.preventDefault();
    if($(this).attr("value")=="bulk-delete"){
    var form = $("#frm-ticket").serialize();
    axios.post('{{ route('tickets.bulk.delete') }}', form)
    .then(function (response) {
    toastr.warning(response.data.message, '@langapp('response_status') ');
    window.location.href = response.data.redirect;
    })
    .catch(function (error) {
        showErrors(error);
    });
    }
    if($(this).attr("value")=="bulk-close"){
    var form = $("#frm-ticket").serialize();
    axios.post('{{ route('tickets.bulk.close') }}', form)
    .then(function (response) {
    toastr.success(response.data.message, '@langapp('response_status') ');
    window.location.href = response.data.redirect;
    })
    .catch(function (error) {
        showErrors(error);
    });
    }

    if($(this).attr("value")=="bulk-open"){
        var form = $("#frm-ticket").serialize();
        axios.post('{{ route('tickets.bulk.open') }}', form)
        .then(function (response) {
            toastr.success(response.data.message, '@langapp('response_status') ');
            window.location.href = response.data.redirect;
        })
        .catch(function (error) {
            showErrors(error);
        });
    }

    if($(this).attr("value")=="bulk-archive"){
        var form = $("#frm-ticket").serialize();
        axios.post('{{ route('archive.process') }}', form)
        .then(function (response) {
        toastr.warning(response.data.message, '@langapp('response_status') ');
        window.location.href = response.data.redirect;
        })
        .catch(function (error) {
            showErrors(error);
        });
    }

    });

    function showErrors(error){
        var errors = error.response.data.errors;
        var errorsHtml= '';
        $.each( errors, function( key, value ) {
        errorsHtml += '<li>' + value[0] + '</li>';
        });
        toastr.error( errorsHtml , '@langapp('response_status') ');
    }

    });
</script>
@endpush
@endsection