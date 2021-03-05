@extends('layouts.app')

@section('content')

<section id="content" class="bg-indigo-100">

    <section class="vbox">
        <header class="px-2 py-2 bg-white border-b border-gray-400 panel-heading">
            <div class="flex justify-between text-gray-500">
                <div>
                    <div class="btn-group">

                        <button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown">
                            @langapp('filter')
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">


                            <li><a href="{{route('payments.index', ['filter' => 'today'])}}">@langapp('today')</a></li>
                            <li><a href="{{route('payments.index', ['filter' => 'yesterday'])}}">@langapp('yesterday')</a>
                            </li>
                            <li><a href="{{route('payments.index', ['filter' => 'week'])}}">@langapp('this_week')</a></li>
                            <li><a href="{{route('payments.index', ['filter' => 'month'])}}">@langapp('this_month')</a></li>
                            <li><a href="{{route('payments.index', ['filter' => 'archived'])}}">@langapp('archived')</a>
                            </li>
                            <li><a href="{{route('payments.index')}}">@langapp('all') </a></li>

                        </ul>
                    </div>
                </div>
                <div>
                    @admin
                    <a href="{{route('payments.export')}}" data-toggle="tooltip" data-placement="bottom" title="@langapp('download')" class="btn {{themeButton()}}">
                        @icon('solid/cloud-download-alt') CSV
                    </a>
                    @endadmin
                </div>
            </div>
        </header>
        <section class="scrollable wrapper">
            <section class="panel panel-default">

                <form id="frm-payment" method="POST">
                    <input type="hidden" name="module" value="payments">
                    <div class="table-responsive">
                        <table class="table table-striped" id="payments-table">
                            <thead>
                                <tr>
                                    <th class="hide display-none"></th>
                                    <th class="no-sort">
                                        <label>
                                            <input name="select_all" value="1" id="select-all" type="checkbox" />
                                            <span class="label-text"></span>
                                        </label>
                                    </th>
                                    <th class="">@langapp('code')</th>
                                    <th class="">@langapp('client_name') </th>
                                    <th class="col-date">@langapp('payment_date') </th>
                                    <th class="col-date">@langapp('invoice_date') </th>
                                    <th class="col-currency">@langapp('amount') </th>
                                    <th class="">@langapp('payment_method') </th>

                                </tr>
                            </thead>

                        </table>

                        @can('payments_update')
                        <button type="submit" class="btn m-1 {{themeButton()}}" value="bulk-archive">
                            @icon('solid/archive') @langapp('archive')
                        </button>
                        @endcan

                        @can('payments_delete')
                        <button type="submit" class="btn m-1 {{themeButton()}}" value="bulk-delete" data-toggle="tooltip" title="@langapp('delete')">
                            @icon('solid/trash-alt')
                        </button>
                        @endcan


                    </div>

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
    $('#payments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('payments.data') !!}',
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
            { data: 'id', name: 'id', searchable: false },
            { data: 'chk', name: 'chk', orderable: false, searchable: false, sortable: false },
            { data: 'code', name: 'code' },
            { data: 'client_id', name: 'company.name' },
            { data: 'payment_date', name: 'payment_date' },
            { data: 'invoice_date', name: 'AsInvoice.created_at', sortable: false },
            { data: 'amount', name: 'amount' },
            { data: 'payment_method', name: 'paymentMethod.method_name' }
        ]
    });

    $("#frm-payment button").click(function(ev){
    ev.preventDefault();

    if($(this).attr("value")=="bulk-delete"){
    var form = $("#frm-payment").serialize();
    axios.post('{{ route('payments.bulk.delete') }}', form)
    .then(function (response) {
        toastr.warning(response.data.message, '@langapp('response_status') ');
        window.location.href = response.data.redirect;
    })
    .catch(function (error) {
        showErrors(error);
    });
    }

    if($(this).attr("value")=="bulk-archive"){
        var form = $("#frm-payment").serialize();
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