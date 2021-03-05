@foreach ($invoices->chunk(2) as $chunk)
<div class="row">
    @foreach ($chunk as $invoice)
    <div class="col-md-6">
        <div class="panel invoice-grid widget-b">
            <div class="panel-body">
                <div class="row">

                    <div class="col-sm-6">
                        <h6 class="">
                            <a class="{{themeLinks('font-bold')}}" href="{{route('invoices.view', $invoice->id)}}">#{{$invoice->reference_no}}</a>
                        </h6>
                        <ul class="list list-unstyled">
                            <li>@langapp('amount') :
                                &nbsp;{{formatCurrency($invoice->currency, $invoice->payable)}}
                            </li>
                            <li>@langapp('date_issued') : <span class="">{{dateFormatted($invoice->created_at)}}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="col-sm-6">

                        <h6 class="font-semibold text-right text-gray-600 no-margin-top">
                            {{formatCurrency($invoice->currency, $invoice->balance)}}
                        </h6>
                        <ul class="text-right list list-unstyled">
                            <li>@langapp('sent') :
                                <span class="text-success">
                                    {{ $invoice->is_sent ? langapp('yes') : langapp('no') }}</span>
                            </li>
                            <li>@langapp('status') :
                                <span class="label label-danger">{{ $invoice->status }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="px-2 py-3 bg-gray-200 border-t border-gray-200 rounded-b-sm">
                <a class="heading-elements-toggle"></a>
                <div class="m-1 heading-elements">
                    <span class="heading-text">
                        <span class="status-mark border-danger position-left"></span> @langapp('due_date') :
                        <span class="font-semibold text-gray-600">{{dateFormatted($invoice->due_date)}}</span>
                    </span>

                    <a href="{{route('invoices.view', $invoice->id)}}" class="btn {{themeButton()}} pull-right">
                        @icon('solid/file-alt') @langapp('preview')
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach