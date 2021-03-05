<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>@langapp('credit_note') {{ $creditnote->reference_no }}</title>
@php
ini_set('memory_limit', '-1');
$ratio = 1.3;
$logo_height = intval(get_option('invoice_logo_height') / $ratio);
$logo_width = intval(get_option('invoice_logo_width') / $ratio);
$color = get_option('creditnote_color');
App::setLocale($creditnote->company->locale);
@endphp

<head>
    <link rel="stylesheet" href="{{ getAsset('css/credits-pdf.css') }}">
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

        .color {
            color: {{$color}};
        }
        .uppercase{
            text-transform: uppercase;
        }

        .bg-color {
            background-color: {{$color}} !important;
            color: #ffffff;
        }

        footer {
            border-top: 1px solid {{$color}};
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
                        <div class="color text-uc font20">{{ stripAccents(langapp('credit_note')) }}</div>

                        <table class="m-t-12 width100">
                            <tr>
                                <td class="text-left color text-uc">
                                    {{ stripAccents(langapp('reference_no')) }}:
                                </td>
                                <td class="text-right">{{ $creditnote->reference_no }}</td>
                            </tr>
                            <tr>
                                <td class="text-left color text-uc">
                                    {{ stripAccents(langapp('credit_date'))  }}:
                                </td>
                                <td class="text-right">{{ dateString($creditnote->created_at) }}</td>
                            </tr>
                            <tr>
                                <td class="text-left color text-uc">
                                    {{ stripAccents(langapp('balance')) }}:
                                </td>
                                <td class="text-right">{{ formatCurrency($creditnote->currency, $creditnote->balance) }}</td>
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
                <td class="width45 color text-uc b-b">{{  stripAccents(langapp('received_from'))  }}</td>
                <td class="width10">&nbsp;</td>
                @endif
                <td class="color text-uc width45 b-b">{{ stripAccents(langapp('bill_to')) }}</td>
                @if (get_option('swap_to_from') == 'TRUE')
                <td class="width10">&nbsp;</td>
                <td class="color text-uc width45 b-b">{{ stripAccents(langapp('received_from')) }}</td>
                @endif
            </tr>
            @php $data['company'] = $creditnote->company; @endphp
                <tr>
                    @if (get_option('swap_to_from') == 'FALSE')
                    <td class="width45">
                        {!! formatCompanyAddress($data) !!}
                    </td>
                    <td class="width10">&nbsp;</td>
                    @endif
                    <td class="width45">
                        {!! formatClientAddress($creditnote, 'invoice', 'billing', false) !!}
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
    $showTax = $creditnote->tax_per_item == 1 ? true :false;
    $colspan = 1;
    if ($showTax) {
        $colspan+=1;
    }
    @endphp
    <table class="items width100 item-table" cellpadding="10">
        <thead>
            <tr>
                <td class="text-left width45">{{  stripAccents(langapp('product'))  }}</td>
                <td class="width10">{{ stripAccents(langapp('qty')) }} </td>
                <td class="width15">{{ itemUnit() }}</td>
                @if ($showTax)
                    <td class="width15">{{ stripAccents(langapp('tax'))}} </td>
                @endif
                <td class="text-right width15">{{ stripAccents(langapp('total')) }} </td>
            </tr>
        </thead>
        <tbody>
            <!-- ITEMS HERE -->
            @foreach ($creditnote->items as $idx => $item)
            <tr class={{  $idx + 1 == count($creditnote->items) ? 'last' : ''  }}>
                <td class="text-left width45">
                    <div class="item-name m-b-6">{{ $item->name }}</div>
                    {{  nl2br($item->description)  }}
                </td>
                <td class="text-center width10">{{ formatQuantity($item->quantity) }}</td>
                <td class="text-right width15">{{ formatCurrency($creditnote->currency, $item->unit_cost) }}</td>
                @if ($showTax)
                <td class="text-right width15">{{ formatCurrency($creditnote->currency, $item->tax_total) }}</td>
                @endif
                <td class="text-right width15">{{ formatCurrency($creditnote->currency, $item->total_cost) }}</td>
                
            </tr>
            @endforeach
            
            <tr class="first">
                <td colspan="{{ $colspan }}" class="white-bg"></td>
                <td colspan="2">@langapp('total')</td>
                <td class="text-right">{{ formatCurrency($creditnote->currency, $creditnote->subTotal()) }}</td>
            </tr>
            @if ($creditnote->tax > 0)
            <tr>
                <td colspan="{{ $colspan }}" class="white-bg"></td>
                <td colspan="2">@langapp('tax') ({{ formatTax($creditnote->tax) }}%)</td>
                <td class="text-right">{{ formatCurrency($creditnote->currency, $creditnote->tax()) }}</td>
            </tr>
            @endif

            @foreach ($creditnote->taxes->groupBy('tax_type_id') as $taxes)
                <tr class="taxes">
                    <td class="white-bg totalsColspan" colspan="{{$colspan}}"></td>
                    <td colspan="2">
                        {{ $taxes[0]->taxtype->name }} ({{ formatTax($taxes[0]->percent) }}%)
                    </td>
                    <td class="text-right">
                        <span id="tax-{{$taxes[0]->id}}">
                            {{ formatCurrency($creditnote->currency, $creditnote->taxTypeAmount($taxes)) }}
                        </span>
                    </td>
                </tr>
            @endforeach
            
            @if ($creditnote->usedCredits() > 0)
            <tr>
                <td colspan="{{  $colspan  }}" class="white-bg"></td>
                <td colspan="2">@langapp('credits_used')</td>
                <td class="text-right">{{ formatCurrency($creditnote->currency, $creditnote->usedCredits()) }}</td>
            </tr>
            @endif
            <tr>
                <td colspan="{{ $colspan }}" class="white-bg"></td>
                <td class="bg-color" colspan="2">@langapp('balance')</td>
                <td class="text-right bg-color">{{ formatCurrency($creditnote->currency, $creditnote->balance()) }}</td>
            </tr>
        </tbody>
    </table>

    @if (settingEnabled('show_creditnote_sign'))
        <h4 class="text-uc terms">{{ stripAccents(langapp('authorized_signature')) }}</h4>
        <span class="text-muted">.....................................................................</span>
    @endif
    
    <div class="m-t-40">
        <h4 class="text-uc terms">{{ stripAccents(langapp('terms')) }}</h4>
        @parsedown($creditnote->terms)
    </div>
    <footer>
        <div class="text-left foot">
            @parsedown(get_option('creditnote_footer'))
        </div>
        <div class="text-right page-num">
            <div class="pagenum-container">Page <span class="pagenum"></span></div>
        </div>
    </footer>
</body>

</html>