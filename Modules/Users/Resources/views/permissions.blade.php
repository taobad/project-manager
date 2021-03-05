@extends('layouts.app')
@section('content')
<section id="content" class="bg">
    <section class="hbox stretch">
        <section class="vbox">
            <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                <div class="flex justify-between text-gray-500">
                    <div>
                        @can('menu_users')
                        <a href="{{ route('users.index') }}" class="btn {{themeButton()}}">
                            @icon('solid/chevron-left') @langapp('users')
                        </a>
                        @endcan
                    </div>
                    <div>
                        @can('roles_create')
                        <a href="{{ route('users.perm.create') }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                            @icon('solid/plus') @langapp('create')
                        </a>
                        @endcan
                    </div>
                </div>
            </header>
            <section class="scrollable wrapper">
                <section class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped" id="permissions-table">
                            <thead>
                                <tr>
                                    <th class="">@langapp('name') </th>
                                    <th class="">@langapp('description') </th>
                                    <th class=""></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Spatie\Permission\Models\Permission::getPermissions([]) as $key => $permission)
                                <tr>
                                    <td>{{ humanize($permission->name) }}</td>
                                    <td class="text-gray-600">{{ $permission->description }}</td>
                                    <td>

                                        <a href="{{ route('users.perm.edit', $permission->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                                            @icon('solid/pencil-alt')
                                        </a>
                                        <a href="{{ route('users.perm.delete', $permission->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
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
    var table = $('#permissions-table').DataTable({
    processing: true,
    order: [[ 0, "asc" ]],
});
});
</script>
@endpush
@endsection