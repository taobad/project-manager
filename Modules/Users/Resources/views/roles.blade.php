@extends('layouts.app')
@section('content')

<section id="content" class="bg">
    <section class="hbox stretch">
        <section class="vbox">
            <header class="bg-white header panel-heading b-b b-light">
                @can('menu_users')
                <a href="{{ route('users.index') }}" class="btn {{themeButton()}}">
                    @icon('solid/chevron-left') @langapp('users')
                </a>
                @endcan
                @can('roles_create')
                <a href="{{ route('users.roles.create') }}" data-toggle="ajaxModal" class="btn {{themeButton()}} pull-right">
                    @icon('solid/plus') @langapp('create')
                </a>
                @endcan
            </header>
            <section class="scrollable wrapper">
                <section class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped" id="roles-table">
                            <thead>
                                <tr>
                                    <th class="hide">ID</th>
                                    <th class="">@langapp('name')</th>
                                    <th class="">Guard</th>
                                    <th class=""></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Role::get() as $key => $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ ucfirst($role->name) }}</td>

                                    <td class="">
                                        {{ $role->guard_name }}
                                    </td>
                                    <td>

                                        <a href="{{ route('users.roles.permission', $role->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                                            @icon('solid/shield-alt')
                                        </a>

                                        <a href="{{ route('users.roles.edit', $role->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                                            @icon('solid/pencil-alt')
                                        </a>
                                        <a href="{{ route('users.roles.delete', $role->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                                            @icon('solid/trash-alt')
                                        </a>


                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

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
var table = $('#roles-table').DataTable({
processing: true,
order: [[ 0, "asc" ]],
});
});
</script>
@endpush
@endsection