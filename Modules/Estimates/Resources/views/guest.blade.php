@extends('layouts.public')
@section('content')

<section id="content" class="details-page public-page">
    <div class="container clearfix details-container bg">
        <section class="vbox">
            <header class="header b-b b-light hidden-print">

                <a href="{{ URL::signedRoute('estimates.guestaccept', $estimate->id) }}" class="btn {{themeButton()}} pull-right">
                    @icon('solid/check-circle') @langapp('accept')
                </a>
                <a href="{{ URL::signedRoute('estimates.guestdecline', $estimate->id) }}" class="btn {{themeButton()}} pull-right" data-toggle="ajaxModal">
                    @icon('solid/times') @langapp('decline')
                </a>



                <a href="{{ route('estimates.view', $estimate->id) }}" class="btn {{themeButton()}}">@icon('solid/home') @langapp('dashboard')
                </a>
                <a href="{{ URL::signedRoute('estimates.guestpdf', $estimate->id) }}" class="btn {{themeButton()}}">
                    @icon('solid/file-pdf') PDF</a>


            </header>
            <section class="wrapper panel-default">
                <div class="panel-body">

                    @if($estimate->status == langapp('accepted'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fas fa-check-circle"></i> <strong>@langapp('accepted')</strong> - {{ dateTimeFormatted($estimate->accepted_time) }} (
                        {{ dateElapsed($estimate->accepted_time) }} )
                    </div>
                    @endif
                    @if($estimate->status == langapp('declined'))
                    <div class="alert alert-danger">
                        <i class="fas fa-times"></i> <strong>@langapp('declined')</strong> - {{ dateTimeFormatted($estimate->rejected_time) }} (
                        {{ dateElapsed($estimate->rejected_time) }} )
                    </div>
                    @endif

                    @php $data['company'] = $estimate->company; @endphp

                    <div class="row">
                        <div class="col-xs-6 with-responsive-img">
                            <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('invoice_logo'))  }}">
                        </div>
                        <div class="text-right col-xs-6">
                            <p class="estimate-code">#{{ $estimate->reference_no }}</p>

                            <div class="estimate-header-text">@langapp('invoice_date')
                                : {{ dateString($estimate->created_at) }}
                            </div>


                            <div class="estimate-header-text">@langapp('due_date')
                                : {{ dateString($estimate->due_date) }}
                            </div>


                            <div class="estimate-header-text">@langapp('status')
                                : <span class="label label-{{ $estimate->status == 'Accepted' ? 'success' : 'danger' }}">{{ $estimate->status }}
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="bg-white well m-t">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="h3">@langapp('client') </p>

                                @include('partial.client_address', $data)

                            </div>
                            <div class="col-xs-6">
                                <p class="h3">@langapp('company_name') </p>
                                @include('partial.company_address', $data)


                            </div>
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
                            @foreach ($estimate->items as $key => $item)
                            <tr>
                                <td><span class="text-bold">{{ $item->name }}</span>
                                    <div class="text-muted">@parsedown($item->description)</div>
                                </td>
                                <td>{{ formatQuantity($item->quantity) }}</td>
                                <td>{{ formatCurrency($estimate->currency, $item->unit_cost) }}</td>
                                <td>{{ $item->discount }}%</td>
                                @if ($showtax)
                                <td><span class="text-muted">{{  formatTax($item->tax_rate)  }}%</span></td>
                                @endif
                                <td class="text-right">{{  formatCurrency($estimate->currency, $item->total_cost) }}</td>
                            </tr>
                            @endforeach
                            @php $colspan = ($showtax) ? 5 : 4; @endphp
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right"><strong>@langapp('sub_total') </strong></td>
                                <td class="text-right">{{  formatCurrency($estimate->currency, $estimate->subtotal())  }}</td>
                            </tr>
                            @if ($estimate->discount > 0)
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right no-border">
                                    <strong>
                                        @langapp('discount') - {{ formatDecimal($estimate->discount) }}%
                                    </strong>
                                </td>
                                <td class="text-right">{{  formatCurrency($estimate->currency, $estimate->discounted())  }}</td>
                            </tr>
                            @endif
                            @if ($estimate->tax > 0.00)
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right no-border"><strong>
                                        {{  get_option('tax1Label')  }} ({{  formatTax($estimate->tax)  }}%)</strong></td>
                                <td class="text-right">{{  formatCurrency($estimate->currency, $estimate->tax1Amount())  }}</td>
                            </tr>
                            @endif
                            @if ($estimate->tax2 > 0.00)
                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right no-border"><strong>
                                        {{  get_option('tax2Label')  }} ({{  formatTax($estimate->tax2)  }}%)</strong></td>
                                <td class="text-right">{{  formatCurrency($estimate->currency, $estimate->tax2Amount())  }}</td>
                            </tr>
                            @endif


                            <tr>
                                <td colspan="{{  $colspan  }}" class="text-right no-border">
                                    <strong>@langapp('amount')</strong></td>
                                <td class="text-right"><strong>{{  formatCurrency($estimate->currency, $estimate->amount())  }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    @if (in_array($estimate->currency, config('system.supported_currency_words')))
                    <p class="text-bold">{{  toWords($estimate->amount(), $estimate->currency)  }}</p>
                    @endif
                    @if($estimate->status == langapp('declined'))
                    <h3 class="h3">Decline Reason</h3>
                    <blockquote class="text-danger">
                        @parsedown($estimate->rejected_reason)
                    </blockquote>
                    @endif

                    <p class="">
                        @parsedown($estimate->notes)
                    </p>

                    {{ $estimate->viewed() }}

                </div>
            </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
    </div>
</section>


@endsection