@extends('layouts.app')
@section('content')
<section id="content" class="bg-indigo-100">
    <section class="vbox">
        <header class="px-2 py-2 bg-white border-b border-gray-400 panel-heading">
            <div class="flex justify-between text-gray-500">
                <div></div>
                <div>
                    @can('taxes_create')
                    <a href="{{ route('rates.create') }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                        @icon('solid/plus') @langapp('create')
                    </a>
                    @endcan
                </div>
            </div>
        </header>
        <section class="scrollable wrapper">
            <section class="panel panel-default">

                <div class="table-responsive">
                    <table class="table table-striped" id="rates-table">
                        <thead>
                            <tr>
                                <th>@langapp('name')</th>
                                <th>@langapp('tax_rate')</th>
                                <th class="no-sort"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rates as $key => $r)
                            <tr>
                                <td class="font-semibold text-gray-600">{{ $r->name }}</td>
                                <td>{{ $r->rate }} %</td>
                                <td>
                                    @can('taxes_update')
                                    <a class="btn {{themeButton()}}" href="{{ route('rates.edit', $r->id)}}" data-toggle="ajaxModal" title="@langapp('edit')">
                                        @langapp('edit')
                                    </a>
                                    @endcan
                                    @can('taxes_delete')
                                    <a class="btn {{themeButton()}}" href="{{ route('rates.delete', $r->id)}}" data-toggle="ajaxModal" title="@langapp('delete')">
                                        @langapp('delete')
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    $('#rates-table').DataTable({
    processing: true,
    });
    });
</script>
@endpush
@endsection