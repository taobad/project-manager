@extends('layouts.app')

@section('content')

<section id="content" class="bg-indigo-100">
    <section class="hbox stretch">
        <section class="vbox">
            <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                <div class="flex justify-between text-gray-500">
                    <div>
                        <div class="btn-group">
                            <button class="btn {{themeButton()}} dropdown-toggle" data-toggle="dropdown"> @langapp('filter')
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach(Role::get() as $role)
                                <li>
                                    <a href="{{ route('users.index', ['filter' => $role->name]) }}">
                                        {{ ucfirst($role->name) }}
                                    </a>
                                </li>
                                @endforeach
                                <li>
                                    <a href="{{ route('users.index') }}">@langapp('all') </a>
                                </li>

                            </ul>
                        </div>
                        @can('roles_view_all')
                        <a href="{{route('users.roles')}}" class="btn {{themeButton()}}">
                            @icon('solid/user-secret') @langapp('roles')
                        </a>
                        <a href="{{route('users.perm')}}" class="btn {{themeButton()}}">
                            @icon('solid/shield-alt') @langapp('permissions')
                        </a>
                        @endcan
                    </div>

                    <div>
                        @admin
                        <a href="{{route('users.export')}}" class="btn {{themeButton()}}">
                            @icon('solid/download') CSV
                        </a>
                        @endadmin

                        @can('users_create')
                        <a href="{{ route('users.create') }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                            @icon('solid/plus') @langapp('create')
                        </a>
                        @endcan

                        @if(isAdmin() || can('announcements_create'))
                        <a href="{{ route('announcements.index') }}" class="btn {{themeButton()}}">
                            @icon('solid/bullhorn') @langapp('announcements')
                        </a>
                        @endif

                    </div>
                </div>
            </header>
            <section class="scrollable wrapper">
                <section class="panel panel-default">
                    <form id="frm-user" method="POST">

                        <div class="table-responsive">

                            <table class="table table-striped" id="users-table">
                                <thead>
                                    <tr>
                                        <th class="hide"></th>
                                        <th class="no-sort">
                                            <label>
                                                <input name="select_all" value="1" id="select-all" type="checkbox" />
                                                <span class="label-text"></span>
                                            </label>
                                        </th>
                                        <th class="">@langapp('name') </th>
                                        <th class="">@langapp('email') </th>
                                        <th class="">@langapp('job_title') </th>
                                        <th class="">@langapp('mobile') </th>
                                        <th class="">@langapp('last_login') </th>
                                    </tr>
                                </thead>

                            </table>


                            @can('users_update')
                            <button type="submit" id="button" class="btn {{themeButton()}} m-xs" value="bulk-verify">
                                <span data-rel="tooltip" title="Verify user account" data-placement="right">@icon('solid/lock-open') @langapp('verify')</span>
                            </button>
                            @endcan

                            @can('users_delete')
                            <button type="submit" id="button" class="btn {{themeButton()}} m-xs" value="bulk-delete">
                                <span data-rel="tooltip" title="Are you sure?" data-placement="right">@icon('solid/trash-alt') @langapp('delete')</span>
                            </button>
                            @endcan



                        </div>




                    </form>





                </section>
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
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('users.data') !!}',
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
            { data: 'email', name: 'email' },
            { data: 'job_title', name: 'profile.job_title' },
            { data: 'mobile', name: 'profile.mobile' },
            { data: 'login', name: 'profile.city' }
        ]
    });

    $("#frm-user button").click(function(ev){
    ev.preventDefault();
    if($(this).attr("value") == "bulk-delete"){
    var form = $("#frm-user").serialize();
    axios.post('{{ route('users.bulk.delete') }}', form)
        .then(function (response) {
            toastr.warning(response.data.message, '@langapp('response_status') ');
            window.location.href = response.data.redirect;
    })
    .catch(function (error) {
    var errors = error.response.data.errors;
    var errorsHtml= '';
    $.each( errors, function( key, value ) {
        errorsHtml += '<li>' + value[0] + '</li>';
    });
        toastr.error( errorsHtml , '@langapp('response_status') ');
    });
    }

    if($(this).attr("value") == "bulk-verify"){
        var form = $("#frm-user").serialize();
        axios.post('{{ route('users.bulk.verify') }}', form)
            .then(function (response) {
                toastr.success(response.data.message, '@langapp('response_status') ');
                window.location.href = response.data.redirect;
        })
        .catch(function (error) {
        var errors = error.response.data.errors;
        var errorsHtml= '';
        $.each( errors, function( key, value ) {
            errorsHtml += '<li>' + value[0] + '</li>';
        });
            toastr.error( errorsHtml , '@langapp('response_status') ');
        });
    }
    
    });

});
</script>
@endpush

@endsection