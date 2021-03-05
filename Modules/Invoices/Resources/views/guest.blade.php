@extends('layouts.public')
@section('content')
<section id="content" class="details-page public-page">
    <div class="container clearfix details-container bg">
        <section class="vbox">
            <section class="wrapper panel-default">
                <header class="header b-b b-light hidden-print">
                    <div class="m-t-xs">
                        <a href="{{  route('invoices.view', $invoice->id)  }}" class="btn {{themeButton()}}">@icon('solid/home') @langapp('dashboard')
                        </a>
                        <a href="{{ URL::signedRoute('invoices.guestpdf', $invoice->id) }}" class="btn {{themeButton()}}">
                            @icon('solid/file-pdf') PDF</a>
                        @if($invoice->due() > 0)
                        @include('invoices::_includes.payment_links')
                        @endif

                        <span class="label label-danger pull-right">{{ $invoice->status }}</span>

                    </div>


                </header>
                <div class="panel-body">
                    @php $data['company'] = $invoice->company; @endphp
                    <div class="row">
                        <div class="col-xs-6 with-responsive-img">
                            <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('invoice_logo')) }}">
                        </div>
                        <div class="text-right col-xs-6">
                            <p class="font20">#{{  $invoice->reference_no  }}</p>
                            <div class="estimate-header-text">
                                {{  stripAccents(langapp('invoice_date'))  }}
                                : {{  dateString($invoice->created_at)  }}
                            </div>
                            <div class="estimate-header-text">
                                {{   stripAccents(langapp('payment_due'))   }}
                                : {{  dateString($invoice->due_date)  }}
                            </div>
                            <div class="estimate-header-text">
                                {{   stripAccents(langapp('status'))   }}
                                : <strong>{{  $invoice->isOverdue() ? langapp('overdue') : $invoice->status  }}</strong>
                            </div>
                        </div>
                    </div>

                    @php
                    $data['company'] = $invoice->company;
                    $address_span = $invoice->show_shipping_on_invoice == 1 ? 4 : 6;
                    @endphp
                    <div class="p-4 mt-2 mb-3 bg-gray-100 border rounded-lg">
                        <div class="row">
                            @if (get_option('swap_to_from') == 'FALSE')
                            <div class="col-xs-{{$address_span}}">
                                <strong>@langapp('received_from'):</strong>
                                <address>
                                    {!! formatCompanyAddress($data) !!}
                                </address>
                                @if(get_option('contact_person'))
                                <address>
                                    <strong>@langapp('contact_person') </strong><br>
                                    <a class="text-indigo-600" href="mailto:{{ get_option('company_email') }}">{{ get_option('contact_person') }}</a>
                                </address>
                                @endif
                            </div>
                            @endif
                            {{-- / SWAP FROM ADDRESS --}}

                            <div class="col-xs-{{$address_span}}">
                                <strong>@langapp('bill_to'):</strong>
                                <div class="pmd-card-body">
                                    <address>
                                        {!! formatClientAddress($invoice, 'invoice', 'billing', true) !!}
                                    </address>
                                    @if($invoice->company->primary_contact)
                                    <address>
                                        <strong>@langapp('contact_person') </strong><br>
                                        <a class="text-indigo-600" href="mailto:{{ $invoice->company->contact->email }}">{{ $invoice->company->contact->name }}</a>
                                    </address>
                                    @endif
                                </div>

                                @can('invoices_update')
                                @if ($invoice->company->unbilledExpenses() > 0 && $invoice->isEditable())
                                <span class="text-info hidden-print">
                                    <a href="{{route('items.expenses', $invoice->id)}}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                                        @langapp('expenses_available')
                                    </a>
                                </span>
                                @endif
                                @endcan
                            </div>
                            @if (get_option('swap_to_from') == 'TRUE')
                            <div class="col-xs-{{$address_span}}">
                                <strong>@langapp('received_from'):</strong>
                                <address>
                                    {!! formatCompanyAddress($data) !!}
                                </address>
                                @if(get_option('contact_person'))
                                <address>
                                    <strong>@langapp('contact_person') </strong><br>
                                    <a class="text-indigo-600" href="mailto:{{ get_option('company_email') }}">{{ get_option('contact_person') }}</a>
                                </address>
                                @endif
                            </div>
                            @endif
                            @if($invoice->show_shipping_on_invoice == 1)
                            <div class="col-xs-{{$address_span}}">
                                <strong>Ship To:</strong>
                                <address>
                                    {!! formatClientAddress($invoice, 'invoice', 'shipping') !!}
                                </address>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="line"></div>
                    @php $showtax = get_option('show_invoice_tax') == 'TRUE' ? true : false; @endphp
                    <table class="table">
                        <thead>
                            <tr class="text-uc">
                                <th width="40%">@langapp('product')</th>
                                <th width="10%">@langapp('qty')</th>
                                <th width="15%">{{ itemUnit() }}</th>
                                <th width="10%">@langapp('disc')</th>
                                @if ($showtax)
                                <th width="10%">@langapp('tax')</th>
                                @endif
                                <th width="15%" class="text-right">@langapp('total')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->items as $key => $item)
                            <tr>
                                <td><span class="text-bold">{{ $item->name }}</span>
                                    <div class="text-gray-600">@parsedown($item->description)</div>
                                </td>
                                <td>{{ formatQuantity($item->quantity) }}</td>
                                <td>{{ formatCurrency($invoice->currency, $item->unit_cost) }}</td>
                                <td>{{ $item->discount }}%</td>
                                @if ($showtax)
                                <td><span class="text-gray-600">{{  formatTax($item->tax_rate)  }}%</span></td>
                                @endif
                                <td class="text-right">{{  formatCurrency($invoice->currency, $item->total_cost) }}</td>
                            </tr>
                            @endforeach
                            @php $colspan = ($showtax) ? 5 : 4; @endphp
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right"><strong>@langapp('sub_total')
                                    </strong></td>
                                <td class="text-right">{{  formatCurrency($invoice->currency, $invoice->subtotal())  }}
                                </td>
                            </tr>
                            @if ($invoice->discount > 0)
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right no-border">
                                    <strong>
                                        @langapp('discount') - {{ formatDecimal($invoice->discount) }}%
                                    </strong>
                                </td>
                                <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->discounted()) }}
                                </td>
                            </tr>
                            @endif
                            @if ($invoice->tax > 0.00)
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right no-border"><strong>
                                        {{ get_option('tax1Label') }} ({{ formatTax($invoice->tax) }}%)</strong></td>
                                <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->tax1Amount()) }}
                                </td>
                            </tr>
                            @endif
                            @if ($invoice->tax2 > 0.00)
                            <tr>
                                <td colspan="{{ $colspan }}" class="text-right no-border"><strong>
                                        {{ get_option('tax2Label') }} ({{ formatTax($invoice->tax2) }}%)</strong></td>
                                <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->tax2Amount()) }}
                                </td>
                            </tr>
                            @endif
                            @if ($invoice->lateFee() > 0)
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right no-border">
                                    <strong>@langapp('late_fee')</strong>
                                </td>
                                <td class="text-right">
                                    {{ formatCurrency($invoice->currency, $invoice->lateFee()) }}
                                </td>
                            </tr>
                            @endif
                            @if ($invoice->extra_fee > 0)
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right no-border"><strong>
                                        @langapp('extra_fee') ({{ formatDecimal($invoice->extra_fee) }}%)</strong></td>
                                <td class="text-right">{{ formatCurrency($invoice->currency, $invoice->extraFee())}}
                                </td>
                            </tr>
                            @endif
                            @php $payment_made = $invoice->paid(); @endphp
                            @if ($payment_made > 0)
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right no-border">
                                    <strong>@langapp('payment_made') </strong>
                                </td>
                                <td class="text-right">{{  formatCurrency($invoice->currency, $payment_made)  }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right no-border">
                                    <strong>@langapp('balance_due') </strong></td>
                                <td class="text-right text-bold">
                                    {{  formatCurrency($invoice->currency, $invoice->due())  }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($invoice->late_fee > 0 && !$invoice->isOverdue())
                    <p class="text-danger">Late fee of {{ $invoice->late_fee_percent === 0 ? $invoice->currency : '' }}
                        {{ $invoice->late_fee }} {{ $invoice->late_fee_percent ? '%' : '' }} will be applied.</p>
                    @endif
                    @if (in_array($invoice->currency, config('system.supported_currency_words')))
                    <p class="text-bold">{{ toWords($invoice->due(), $invoice->currency) }}</p>
                    @endif
                    <p class="">
                        @php
                        $str = str_replace('{REMAINING_DAYS}', $invoice->dueDays().' days', $invoice->notes);
                        $str = str_replace('{PAYMENT_DETAILS}', get_option('invoice_payment_info'), $str);
                        @endphp
                        @parsedown($str)
                    </p>
                </div>
            </section>
            {{ $invoice->clientViewed() }}
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
    </div>
</section>
@push('pagescript')
@if ($invoice->gatewayEnabled('braintree'))
<script src="https://js.braintreegateway.com/web/dropin/1.14.1/js/dropin.min.js"></script>
@endif
@if ($invoice->gatewayEnabled('stripe'))
<script src='https://js.stripe.com/v3/' type='text/javascript'></script>
@endif

@if($invoice->gatewayEnabled('square'))
@php
$squarejs = config('services.square.sandbox') ? 'https://js.squareupsandbox.com/v2/paymentform' :
'https://js.squareup.com/v2/paymentform';
@endphp
<script type="text/javascript" src="{{$squarejs}}"></script>

@endif

@endpush
@endsection