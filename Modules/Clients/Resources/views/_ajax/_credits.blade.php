@foreach ($credits->chunk(2) as $chunk)
<div class="row">
    @foreach ($chunk as $credit)
    <div class="col-md-6">
        <div class="panel invoice-grid widget-b">
            <div class="panel-body">
                <div class="row">

                    <div class="col-sm-6">
                        <h6 class="text-semibold"><a href="{{  route('creditnotes.view', ['creditnote' => $credit->id])  }}">#{{  $credit->reference_no  }}</a>
                        </h6>
                        <ul class="list list-unstyled">
                            <li>@langapp('balance') :
                                &nbsp;{{  formatCurrency($credit->currency, $credit->balance())  }}</li>
                            <li>@langapp('date_issued') : <span class="text-semibold">{{ dateFormatted($credit->created_at) }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="col-sm-6">

                        <h6 class="text-semibold text-right no-margin-top">
                            {{  formatCurrency($credit->currency, $credit->amount)  }}
                        </h6>
                        <ul class="list list-unstyled text-right">
                            <li>@langapp('sent') :
                                <span class="text-semibold text-success">
                                    {{ $credit->is_sent ? langapp('yes') : langapp('no') }}</span>
                            </li>
                            <li>@langapp('status') :
                                <span class="label label-danger text-uc">{{ $credit->status }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="panel-footer panel-footer-condensed">
                <a class="heading-elements-toggle"></a>
                <div class="heading-elements">
                    <span class="heading-text">
                        @icon('solid/check-circle', 'text-success') @langapp('used') : <span class="text-semibold">{{  formatCurrency($credit->currency, $credit->used)  }}</span>
                    </span>
                    @can('invoices_send')
                    <a href="{{ route('creditnotes.send', $credit->id) }}" class="btn {{themeButton()}} pull-right" data-toggle="ajaxModal">
                        @icon('regular/envelope-open') @langapp('send')
                    </a>
                    @endcan


                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach