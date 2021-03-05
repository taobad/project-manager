@extends('layouts.app')
@section('content')
<section id="content">
    <section class="vbox">
        <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
            <div class="flex justify-between text-gray-500">
                <div>
                    <div class="btn-group">
                        <button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown">
                            @langapp('filter')
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('projects.index', ['filter' => 'active']) }}">@langapp('active') </a></li>
                            <li><a href="{{ route('projects.index', ['filter' => 'on_hold']) }}">@langapp('on_hold') </a></li>
                            <li><a href="{{ route('projects.index', ['filter' => 'done']) }}">@langapp('done')</a></li>
                            <li><a href="{{ route('projects.index', ['filter' => 'archived']) }}">@langapp('archived')</a></li>
                            <li><a href="{{ route('projects.index')}}">@langapp('all')</a></li>
                        </ul>
                    </div>
                    @admin
                    <a href="{{ route('projects.index', ['filter' => 'templates']) }}" class="btn {{themeButton()}} ml-1">
                        @icon('solid/recycle') @langapp('templates')</a>
                    @endadmin
                </div>
                <div>
                    @can('projects_create')
                    <a href="{{ route('projects.create')}}" class="btn {{themeButton()}}">
                        @icon('solid/plus') @langapp('create') </a>
                    @endcan
                </div>
            </div>
        </header>

        <section class="bg-indigo-100 scrollable wrapper">
            <section class="panel panel-default">


                <form id="frm-project" method="POST">
                    <input type="hidden" name="module" value="projects">
                    <div class="table-responsive">
                        <table class="table table-striped m-b-none" id="projects-table">
                            <thead>
                                <tr>
                                    <th class="hide"></th>
                                    <th class="no-sort">
                                        <label>
                                            <input name="select_all" value="1" id="select-all" type="checkbox" />
                                            <span class="label-text"></span>
                                        </label>
                                    </th>
                                    <th class="">@langapp('name')</th>
                                    @can('projects_view_clients')
                                    <th class="no-sort">@langapp('client')</th>
                                    @endcan
                                    @can('projects_view_team')
                                    <th class="no-sort">@langapp('team_members')</th>
                                    @endcan

                                    @can('projects_view_used_budget')
                                    <th class="col-currency">@langapp('budget')</th>
                                    @endcan
                                    @can('projects_view_hours')
                                    <th class="">@langapp('total_time') </th>
                                    @endcan
                                    @can('projects_view_cost')
                                    <th class="col-currency">@langapp('amount')</th>
                                    @endcan
                                    @can('projects_view_expenses')
                                    <th class="col-currency">@langapp('expenses') </th>
                                    @endcan
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @can('invoices_create')
                    <button type="submit" class="btn m-1 {{themeButton()}}" value="bulk-invoice">
                        <span class="">@icon('solid/file-invoice-dollar') @langapp('invoice')</span>
                    </button>
                    @endcan
                    @can('projects_delete')
                    <button type="submit" class="btn m-1 {{themeButton()}}" value="bulk-archive">
                        <span class="">@icon('solid/archive') @langapp('archive')</span>
                    </button>
                    @endcan
                    @can('projects_delete')
                    <button type="submit" class="btn m-1 {{themeButton()}}" value="bulk-delete">
                        <span class="">@icon('solid/trash-alt') @langapp('delete')</span>
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
var table = $('#projects-table').DataTable({
processing: true,
serverSide: true,
ajax: {
    url: '{!! route('projects.data') !!}',
    type: 'POST',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
        "filter": '{{ $filter }}',
    }
},
order: [[ 0, "desc" ]],
columns: [
{ data: 'id', name: 'id' },
{ data: 'chk', name: 'chk', orderable: false, searchable: false, sortable: false },
{ data: 'name', name: 'name' },
@can('projects_view_clients')
{ data: 'client_id', name: 'company.name' },
@endcan
@can('projects_view_team')
{ data: 'team', name: 'assignees.user.name' },
@endcan
@can('projects_view_used_budget')
{ data: 'used_budget', name: 'used_budget' },
@endcan
@can('projects_view_hours')
{ data: 'billable_time', name: 'billable_time' },
@endcan
@can('projects_view_cost')
{ data: 'sub_total', name: 'sub_total' },
@endcan
@can('projects_view_expenses')
{ data: 'total_expenses', name: 'total_expenses' },
@endcan
]
});
$("#frm-project button").click(function(ev){
ev.preventDefault();
if($(this).attr("value") == "bulk-delete"){
var form = $("#frm-project").serialize();
axios.post('{{ route('projects.bulk.delete') }}', form)
.then(function (response) {
    toastr.warning(response.data.message, '@langapp('response_status') ');
    window.location.href = response.data.redirect;
})
.catch(function (error) {
    showErrors(error);
});
}
if($(this).attr("value") == "bulk-archive"){
var form = $("#frm-project").serialize();
axios.post('{{ route('archive.process') }}', form)
.then(function (response) {
    toastr.warning(response.data.message, '@langapp('response_status') ');
    window.location.href = response.data.redirect;
})
.catch(function (error) {
    showErrors(error);
});
}
if($(this).attr("value") == "bulk-invoice"){
    var form = $("#frm-project").serialize();
    axios.post('{{ route('projects.bulk.invoice') }}', form)
    .then(function (response) {
        toastr.success(response.data.message, '@langapp('response_status') ');
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