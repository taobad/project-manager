<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ settingEnabled('rtl') ? 'rtl' : 'ltr' }}">
<title>@langapp('invoice') {{ $invoice->reference_no }}</title>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ getAsset('css/invoice-pdf.css') }}">
    @php
    ini_set('memory_limit', '-1');
    $ratio = 1.3;
    $logo_height = intval(get_option('invoice_logo_height') / $ratio);
    $logo_width = intval(get_option('invoice_logo_width') / $ratio);
    $color = get_option('invoice_color');
    App::setLocale($invoice->company->locale);
    @endphp
    <style>
        body,
        h1,
        h2,
        h3,
        h4 {
            font-family: '{{ config('system.pdf_font') }}';
        }

        table thead td {
            border-bottom: 0.2mm solid {{ $color }};
        }

        table .last td {
            border-bottom: 0.2mm solid {{ $color }};
        }
        .uppercase{
            text-transform: uppercase;
        }

        table .first td {
            border-top: 0.2mm solid {{ $color }};
        }

        .color {
            color: '{{ $color }}';
        }

        .bg-color {
            background-color: {{$color}} !important;
            color: #ffffff;
        }

        footer {
            border-top: 1px solid {{ $color }};
        }

        .b-b {
            border-bottom:0.2mm solid {{$color}};
        }

        .terms {
            padding: 5px 0;
            color: #111111;
            border-bottom: 0.2mm solid {{$color}};
        }

        .logo {
            height: {{ $logo_height }};
            width: {{ $logo_width }};
        }

        .notes-section img {
            width: 450px;
        }
    </style>
    
</head>

<body>
    <div id="container">
        <header>
            <div>
                <table class="width100">
                    <tr>
                        <td class="width60">
                            <img style="height:{{ $logo_height }}px; width:{{$logo_width}}px" src="{{ $logo }}"
                                class="width200" alt="">
                        </td>
                        <td class="text-right width40">
                            <div class="color text-uc font20">{{ stripAccents(langapp('invoice')) }}</div>

                            <table class="m-t-12 width100">
                                <tr>
                                    <td class="text-left color text-uc">
                                        {{ stripAccents(langapp('reference_no'))}}:
                                    </td>
                                    <td class="text-right">{{ $invoice->reference_no}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left color text-uc">
                                        {{ stripAccents(langapp('invoice_date'))}}:
                                    </td>
                                    <td class="text-right">{{ dateFormatted($invoice->created_at) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left color text-uc">
                                        {{ stripAccents(langapp('payment_due')) }}:
                                    </td>
                                    <td class="text-right">{{ dateFormatted($invoice->due_date) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left color text-uc">
                                        {{ stripAccents(langapp('status')) }}:
                                    </td>
                                    <td class="text-right">{{ $invoice->status }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </header>
        <div class="height10">&nbsp;</div>
        <div class="m-b-10">
            <table class="width100 v-t invoice-details" cellpadding="10">
                <tr>
                    @if (get_option('swap_to_from') == 'FALSE')
                    <td class="width45 color text-uc b-b">{{ stripAccents(langapp('received_from')) }}</td>
                    <td class="width10">&nbsp;</td>
                    @endif
                    <td class="color text-uc width45 b-b">{{  stripAccents(langapp('bill_to'))}}</td>
                    @if (get_option('swap_to_from') == 'TRUE')
                    <td class="width10">&nbsp;</td>
                    <td class="width45 color text-uc b-b">{{  stripAccents(langapp('received_from'))}}</td>
                    @endif
                </tr>
                @php $data['company'] = $invoice->company; @endphp
                <tr>
                    @if (get_option('swap_to_from') == 'FALSE')
                    <td class="width45">
                        {!! formatCompanyAddress($data) !!}
                    </td>
                    <td class="width10">&nbsp;</td>
                    @endif
                    <td class="width45">
                        {!! formatClientAddress($invoice, 'invoice', 'billing', false) !!}
                    </td>
                    @if (get_option('swap_to_from') == 'TRUE')
                    <td class="width10">&nbsp;</td>
                    <td class="width45">
                        {!! formatCompanyAddress($data) !!}
                    </td>
                    @endif
                </tr>
            </table>
        </div>

        @php
        $showTax = $invoice->tax_per_item == 1 ? true :false;
        $showDiscount = $invoice->discount_per_item == 1 ? true :false;
        $colspan = 1;
        if ($showTax) {
            $colspan+=1;
        }
        if ($showDiscount) {
            $colspan+=1;
        }
        @endphp

        <table class="items width100 item-table" id="inv-details" cellpadding="10">
            <thead>
                <tr class="inv-text inv-bg text-uc">
                    <td class="text-left width40">{{ stripAccents(langapp('product'))}} </td>
                    <td class="width8">{{ stripAccents(langapp('qty'))}} </td>
                    <td class="width12">{{ itemUnit() }}</td>
                    @if ($showDiscount)
                    <td class="width10">{{ stripAccents(langapp('disc'))}} </td>
                    @endif
                    @if ($showTax)
                    <td class="width10">{{ stripAccents(langapp('tax'))}} </td>
                    @endif
                    <td class="text-right width20">{{  stripAccents(langapp('total'))}} </td>

                </tr>
            </thead>
            <tbody>
                {{-- ITEMS HERE --}}
                @foreach ($invoice->items as $idx => $item)
                <tr class={{$idx + 1 == count($invoice->items) ? 'last' : ''}}>
                    <td class="text-left">
                        <div class="item-name m-b-6">{{ $item->name }}</div>
                        @parsedown($item->description)
                    </td>
                    <td class="text-center">{{ formatQuantity($item->quantity) }}</td>
                    <td class="text-right">{{ $item->unit_cost }}</td>
                    @if ($showDiscount)
                    <td class="text-right">{{ $item->discount }}%</td>
                    @endif
                    @if ($showTax)
                    <td class="text-right">{{ $item->tax_rate}}%</td>
                    @endif
                    <td class="text-right">{{ formatCurrency($invoice->currency, $item->total_cost) }}</td>

                </tr>
                @endforeach

                <tr class="first">
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td colspan="2">@langapp('total')</td>
                    <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->subTotal()) }}</td>
                </tr>
                @if ($invoice->discount > 0)
                <tr>
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td colspan="2">@langapp('discount') - {{  formatDecimal($invoice->discount)}}%</td>
                    <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->discounted()) }}</td>
                </tr>
                @endif
                @if ($invoice->tax != 0)
                <tr>
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td colspan="2">{{ get_option('tax1Label') }} ({{  formatTax($invoice->tax)}}%)</td>
                    <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->tax1Amount()) }}</td>
                </tr>
                @endif
                @if ($invoice->tax2 != 0)
                <tr>
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}">
                        {{ get_option('tax2Label')}} ({{  formatTax($invoice->tax2)}}%)
                    </td>
                    <td colspan="2"></td>
                    <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->tax2Amount()) }}</td>
                </tr>
                @endif

                @foreach ($invoice->taxes->groupBy('tax_type_id') as $taxes)
                <tr class="taxes">
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td colspan="2">
                        {{ $taxes[0]->taxtype->name }} ({{ formatTax($taxes[0]->percent) }}%)
                    </td>
                    <td class="text-right">
                        <span id="tax-{{$taxes[0]->id}}">
                            {{ formatCurrency($invoice->currency, $invoice->taxTypeAmount($taxes)) }}
                        </span>
                    </td>
                </tr>
                @endforeach

                @if ($invoice->lateFee() > 0)
                <tr>
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td colspan="2">{{ langapp('late_fee') }}</td>
                    <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->lateFee()) }}</td>
                </tr>
                @endif
                @if ($invoice->extra_fee > 0)
                <tr>
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td colspan="2">@langapp('extra_fee') - {{  formatDecimal($invoice->extra_fee)}}%</td>
                    <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->extraFee()) }}</td>
                </tr>
                @endif
                @php $payment_made = $invoice->paid(); @endphp
                @if ($payment_made > 0)
                <tr>
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td colspan="2">@langapp('payment_made')</td>
                    <td class="text-right">{{ formatCurrency($invoice->currency, $payment_made) }}</td>
                </tr>
                @endif
                @if ($invoice->creditedAmount() > 0)
                <tr>
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td colspan="2">@langapp('credits_applied') </td>
                    <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->creditedAmount()) }}</td>
                </tr>
                @endif
                <tr>
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td class="bg-color text-uc" colspan="2">@langapp('balance_due')</td>
                    <td class="text-right bg-color">{{ formatCurrency($invoice->currency, $invoice->due()) }}</td>
                </tr>
            </tbody>
        </table>

        @if (settingEnabled('show_invoice_sign'))
        <h4 class="text-uc terms">{{ stripAccents(langapp('authorized_signature')) }}</h4>
        <span class="text-muted">.....................................................................</span>
        @endif

        @if ($invoice->gatewayEnabled('bank') && settingEnabled('bank_on_invoice_pdf'))
        <h4 class="text-uc terms">{{ stripAccents(langapp('bank_details')) }}</h4>
        <span class="text-muted">@parsedown(get_option('bank_details'))</span>
        @endif
        <div class="m-t-40 notes-section">
            <h4 class="text-uc terms">{{ stripAccents(langapp('payment_information')) }}</h4>
            {!! str_replace('{REMAINING_DAYS!!', $invoice->dueDays().' days', $invoice->notes) !!}
        </div>
        <footer>
            <div class="text-left foot">
                @parsedown(get_option('invoice_footer'))
            </div>
            <div class="text-right page-num">
                <div class="pagenum-container">@langapp('page') <span class="pagenum"></span></div>
            </div>
        </footer>
    </div>
</body>

</html>