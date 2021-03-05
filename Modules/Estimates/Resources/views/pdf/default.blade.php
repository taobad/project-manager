<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>@langapp('estimate') {{ $estimate->reference_no }}</title>
@php
ini_set('memory_limit', '-1');
$ratio = 1.3;
$logo_height = intval(get_option('invoice_logo_height') / $ratio);
$logo_width = intval(get_option('invoice_logo_width') / $ratio);
$color = get_option('estimate_color');
App::setLocale($estimate->company->locale);
@endphp

<head>
    <link rel="stylesheet" href="{{ getAsset('css/estimates-pdf.css') }}">
    <style>
        body {
            font-family: '{{ config('system.pdf_font') }}';
        }

        table thead td {
            border-bottom: 0.2mm solid {{$color}};
        }

        table .last td {
            border-bottom: 0.2mm solid {{$color}};
        }

        table .first td {
            border-top: 0.2mm solid {{$color}};
        }

        .b-b {
            border-bottom:0.2mm solid {{$color}};
        }

        .color {
            color: {{$color}};
        }
        .uppercase{
            text-transform: uppercase;
        }

        .terms {
            padding: 5px 0;
            color: #111111;

            border-bottom: 0.2mm solid {{$color}};
        }

        .bg-color {
            background-color: {{$color}} !important;
            color: #ffffff;
        }

        footer {
            border-top: 1px solid {{$color}};
        }

        .logo {
            height: '{{$logo_height}}'px;
            width: '{{$logo_width}}'px;
        }
    </style>
</head>

<body>
    <header>
        <div>
            <table class="width100">
                <tr>
                    <td class="width60">
                        <img style="height:{{ $logo_height }}px; width:{{$logo_width}}px" src="{{ $logo }}"
                            class="width200" alt="">
                    </td>
                    <td class="text-right width40">
                        <div class="color text-uc font20">{{ stripAccents(langapp('estimate')) }}</div>

                        <table class="m-t-12 width100">
                            <tr>
                                <td class="text-left color text-uc">{{ stripAccents(langapp('reference_no')) }}:</td>
                                <td class="text-right">{{ $estimate->reference_no }}</td>
                            </tr>
                            <tr>
                                <td class="text-left color text-uc">
                                    {{ stripAccents(langapp('estimate_date'))  }}:
                                </td>
                                <td class="text-right">{{ dateString($estimate->created_at) }}</td>
                            </tr>
                            <tr>
                                <td class="text-left color text-uc">
                                    {{ stripAccents(langapp('valid_until')) }}:
                                </td>
                                <td class="text-right">{{ dateString($estimate->due_date) }}</td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </header>
    <div class="height10">&nbsp;</div>
    <div class="m-b-10">
        <table class="width100 v-t" cellpadding="10">
            <tr>
                @if (get_option('swap_to_from') == 'FALSE')
                <td class="color text-uc width45 b-b">{{ stripAccents(langapp('received_from')) }}</td>
                <td class="width10">&nbsp;</td>
                @endif
                <td class="color text-uc width45 b-b">{{ stripAccents(langapp('bill_to')) }}</td>
                @if (get_option('swap_to_from') == 'TRUE')
                <td class="width10">&nbsp;</td>
                <td class="color text-uc width45 b-b">{{  stripAccents(langapp('received_from'))  }}</td>
                @endif
            </tr>
            @php $data['company'] = $estimate->company; @endphp
                <tr>
                    @if (get_option('swap_to_from') == 'FALSE')
                    <td class="width45">
                        {!! formatCompanyAddress($data) !!}
                    </td>
                    <td class="width10">&nbsp;</td>
                    @endif
                    <td class="width45">
                        {!! formatClientAddress($estimate, 'invoice', 'billing', false) !!}
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
    <sethtmlpageheader name="myheader" value="off" />
    @php
    $showTax = $estimate->tax_per_item == 1 ? true :false;
    $showDiscount = $estimate->discount_per_item == 1 ? true :false;
    $colspan = 1;
    if ($showTax) {
        $colspan+=1;
    }
    if ($showDiscount) {
        $colspan+=1;
    }
    @endphp
    <table class="items width100 item-table" cellpadding="10">
        <thead>
            <tr>
                <td class="text-left">{{ stripAccents(langapp('product')) }} </td>
                <td class="width10">{{  stripAccents(langapp('qty')) }} </td>
                <td class="width15">{{ itemUnit() }}</td>
                @if ($showDiscount)
                    <td class="width10">{{ stripAccents(langapp('disc'))}} </td>
                @endif
                @if ($showTax)
                    <td class="width10">{{ stripAccents(langapp('tax'))}} </td>
                @endif
                <td class="width15">{{  stripAccents(langapp('total')) }} </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($estimate->items as $idx => $item)
            <tr{{  $idx + 1 == count($estimate->items) ? ' class="last"' : ''  }}>
                @if (get_option('show_estimate_tax') == 'FALSE')
                <td class="text-left width60">
                    <div class="item-name m-b-6">{{ $item->name }}</div>
                    @parsedown($item->description)
                </td>
                <td class="text-center width10">{{ formatQuantity($item->quantity) }}</td>
                <td class="text-right width15">
                    {{ formatCurrency($estimate->currency, $item->unit_cost) }}
                </td>
                <td class="text-right width15">
                    {{ formatCurrency($estimate->currency, $item->total_cost) }}
                    @else
                <td class="text-left width45">
                    <div class="item-name m-b-6">
                        {{ $item->name }}
                    </div>
                    @parsedown($item->description)
                </td>
                <td class="text-center width10">
                    {{ formatQuantity($item->quantity)  }}
                </td>
                <td class="text-right width15">
                    {{ formatCurrency($estimate->currency, $item->unit_cost) }}
                </td>
                @if ($showDiscount)
                <td class="text-right">{{ $item->discount }}%</td>
                @endif
                @if ($showTax)
                <td class="text-right">{{ formatCurrency($estimate->currency, $item->tax_total) }}</td>
                @endif
                <td class="text-right width15">{{  formatCurrency($estimate->currency, $item->total_cost)  }}</td>
                @endif
                </tr>
                @endforeach
                
                <tr class="first">
                    <td colspan="{{ $colspan }}" class="white-bg"></td>
                    <td colspan="2">@langapp('total')</td>
                    <td class="text-right">{{ formatCurrency($estimate->currency, $estimate->subTotal()) }}</td>
                </tr>
                @if ($estimate->discount > 0)
                <tr>
                    <td colspan="{{ $colspan }}" class="white-bg"></td>
                    <td colspan="2">@langapp('discount') - {{ formatDecimal($estimate->discount) }}%</td>
                    <td class="text-right">{{ formatCurrency($estimate->currency, $estimate->discounted()) }}</td>
                </tr>
                @endif
                
                @if ($estimate->tax > 0)
                <tr>
                    <td colspan="{{ $colspan }}" class="white-bg"></td>
                    <td colspan="2">{{ get_option('tax1Label') }} ({{ formatTax($estimate->tax) }}%)</td>
                    <td class="text-right">{{ formatCurrency($estimate->currency, $estimate->tax1Amount()) }}</td>
                </tr>
                @endif
                @if ($estimate->tax2 > 0)
                <tr>
                    <td colspan="{{ $colspan }}" class="white-bg"></td>
                    <td colspan="2">{{ get_option('tax2Label') }} ({{ formatTax($estimate->tax2)  }}%)</td>
                    <td class="text-right">{{ formatCurrency($estimate->currency, $estimate->tax2Amount()) }}</td>
                </tr>
                @endif

                @foreach ($estimate->taxes->groupBy('tax_type_id') as $taxes)
                <tr class="taxes">
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td colspan="2">
                        {{ $taxes[0]->taxtype->name }} ({{ formatTax($taxes[0]->percent) }}%)
                    </td>
                    <td class="text-right">
                        <span id="tax-{{$taxes[0]->id}}">
                            {{ formatCurrency($estimate->currency, $estimate->taxTypeAmount($taxes)) }}
                        </span>
                    </td>
                </tr>
                @endforeach
                
                <tr>
                    <td colspan="{{ $colspan }}" class="white-bg"></td>
                    <td class="bg-color" colspan="2">@langapp('cost')</td>
                    <td class="text-right bg-color">{{ formatCurrency($estimate->currency, $estimate->amount()) }}</td>
                </tr>
        </tbody>
    </table>

    @if (settingEnabled('show_estimate_sign'))
        <h4 class="text-uc terms">{{ stripAccents(langapp('authorized_signature')) }}</h4>
        <span class="text-muted">.....................................................................</span>
    @endif
        
    <div class="m-t-40">
        <h4 class="text-uc terms">{{ stripAccents(langapp('notes')) }}</h4>
        @parsedown($estimate->notes)
    </div>
    <footer>
        <div class="text-left foot">
            @parsedown(get_option('estimate_footer'))
        </div>
        <div class="text-right page-num">
            <div class="pagenum-container">Page <span class="pagenum"></span></div>
        </div>
    </footer>
</body>

</html>