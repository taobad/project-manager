@extends('layouts.app')

@section('content')


<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <section class="scrollable wrapper bg">
                    <section class="panel panel-default">

                        <header class="panel-heading">

                            @include('analytics::report_header')

                        </header>

                        <div class="panel-body">



                            @php
                            $start_date = date('F d, Y', strtotime($range[0]));
                            $end_date = date('F d, Y', strtotime($range[1]));
                            @endphp


                            <section class="panel panel-default">
                                <header class="panel-heading">@langapp('estimates_reports')</header>
                                <div class="row wrapper analytics">
                                    <div class="col-sm-12 m-b-xs">
                                        <form>

                                            <div class="inline v-middle col-md-4">
                                                <label>@langapp('date_range')</label>
                                                <input type="text" class="form-control" id="reportrange" name="range">
                                            </div>


                                            <div class="inline v-middle">
                                                <label>@langapp('client')</label>
                                                <select class="form-control input-s-sm " id="filter-client" name="client">
                                                    <option value="-">-</option>
                                                    @foreach (Modules\Estimates\Entities\Estimate::select('id', 'client_id')->with('company:id,name')->groupBy('client_id')->get()
                                                    as $est)
                                                    <option value="{{ $est->client_id }}">{{ optional($est->company)->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="inline v-middle">
                                                <label>@langapp('status')</label>
                                                <select class="form-control input-s-sm" id="filter-status" name="status">
                                                    <option value="-">-</option>
                                                    <option value="Pending" selected>@langapp('pending') </option>
                                                    <option value="Accepted">@langapp('accepted') </option>
                                                    <option value="Declined">@langapp('declined') </option>
                                                </select>
                                            </div>

                                            <div class="inline v-middle">
                                                <label>@langapp('sent')</label>
                                                <select class="form-control input-s-sm" id="filter-sent" name="sent">
                                                    <option value="-">-</option>
                                                    <option value="0">@langapp('no') </option>
                                                    <option value="1">@langapp('yes') </option>
                                                </select>
                                            </div>

                                            <div class="inline v-middle">
                                                <label>@langapp('invoiced')</label>
                                                <select class="form-control input-s-sm" id="filter-invoiced" name="invoiced">
                                                    <option value="-">-</option>
                                                    <option value="0">@langapp('no') </option>
                                                    <option value="1">@langapp('yes') </option>
                                                </select>
                                            </div>





                                        </form>

                                    </div>


                                </div>


                                <div id="ajaxData"></div>






                            </section>











                        </div>

                    </section>
                </section>


            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>

@push('pagescript')
@include('analytics::_daterangepicker')
<script type="text/javascript">
    $('#reportrange, #filter-client, #filter-status, #filter-sent, #filter-invoiced').change(function(event) {
        loadData(event);
    }).change();

    function loadData(val) {
            axios.post('{{ route('reports.estimates.filter') }}', {
                range: $('#reportrange').val(),
                client: $('#filter-client').val(),
                status: $('#filter-status').val(),
                sent: $('#filter-sent').val(),
                invoiced_id: $('#filter-invoiced').val(),
            })
            .then(function (response) {
                    $('#ajaxData').html(response.data.html);
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

</script>
@endpush

@endsection