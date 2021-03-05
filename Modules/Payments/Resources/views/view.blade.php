@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <section class="vbox">
            <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                <div class="flex justify-between text-gray-500">
                    <div>
                        @can('payments_update')
                        <a href="{{route('payments.edit', $payment->id)}}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                            @icon('solid/pencil-alt') @langapp('edit')</a>
                        @if ($payment->is_refunded === 0)
                        <a href="{{route('payments.refund', $payment->id)}}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                            @icon('solid/exchange-alt') @langapp('refund')</a>

                        @endif
                        @endcan
                        <a href="{{route('payments.pdf', $payment->id)}}" class="btn {{themeButton()}}">
                            @icon('solid/file-pdf') @langapp('receipt')
                        </a>
                    </div>
                    <div>
                        @can('payments_delete')
                        <a href="{{route('payments.delete', $payment->id)}}" class="pull-right btn {{themeButton()}}" data-toggle="ajaxModal">
                            @icon('solid/trash-alt') @langapp('delete')</a>
                        @endcan
                    </div>
                </div>
            </header>
            <section class="scrollable wrapper bg">
                @if ($payment->is_refunded)
                <div class="alert alert-danger hidden-print">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    @icon('solid/exclamation-circle') @langapp('transaction_refunded')
                </div>
                @endif

                <div class="border-r border-gray-400 col-lg-5">
                    <div class="pb-2 column content-column">


                        <div class="text-sm">
                            <div>
                                <div class="text-center payment-received">
                                    <span class="uppercase payment-received-span">@langapp('payments_received')</span>
                                </div>


                                <div class="{{themeBg()}} pull-right rounded-lg text-white w-40 h-24 px-2 py-2 text-center">
                                    <div class="">
                                        <div class="font-semibold uppercase">
                                            @langapp('amount')
                                        </div>
                                        <div class="text-lg font-semibold">
                                            {{ formatCurrency($payment->currency, $payment->amount)}}
                                        </div>

                                    </div>
                                </div>
                                <div class="m-b-sm">
                                    ID # : <strong>{{ $payment->code }}</strong>
                                </div>
                                <div class="m-b-sm">
                                    @langapp('currency') : <strong>{{ $payment->currency }}</strong>
                                </div>

                                <div class="m-b-sm">
                                    @langapp('payment_method') :
                                    <strong>{{ $payment->paymentMethod->method_name }}</strong>
                                </div>

                                @if($payment->currency != 'USD')
                                <div class="m-b-sm">
                                    @langapp('xrate') :
                                    <strong>1 USD = {{ $payment->currency }}
                                        {{ $payment->exchange_rate  }}</strong>

                                </div>
                                @endif

                                <div class="m-b-sm">
                                    @langapp('date') :
                                    <strong>{{ dateTimeFormatted($payment->payment_date) }}</strong>

                                </div>
                                <div class="m-b-sm">
                                    @langapp('received_from') : <strong><a class="{{themeLinks()}}" href="{{ route('clients.view', ['client' => $payment->client_id])}}">
                                            {{  $payment->company->name }}</a></strong>
                                </div>
                                <div class="line"></div>
                                <small class="text-xs text-gray-600 uppercase">@langapp('invoice') </small>

                                <div class="m-b-sm">
                                    @langapp('reference_no') :
                                    <strong>
                                        <a class="{{themeLinks()}}" href="{{ route('invoices.view', ['invoice' => $payment->invoice_id]) }}">
                                            {{  $payment->AsInvoice->reference_no }}
                                        </a>
                                    </strong>

                                </div>
                                <div class="m-b-sm">
                                    @langapp('date') :
                                    <strong>{{ dateString($payment->AsInvoice->created_at) }}</strong>
                                </div>
                                <div class="m-b-sm">
                                    @langapp('balance') :
                                    <strong>{{ formatCurrency($payment->AsInvoice->currency, $payment->AsInvoice->due()) }}
                                    </strong>
                                </div>
                                <div class="line"></div>
                                <small class="text-xs uppercase text-muted">@langapp('in_words')</small>
                                @if (settingEnabled('amount_in_words'))
                                @widget('Payments\AmountWords', ['currency' => $payment->currency, 'amount' =>
                                $payment->amount])
                                @endif
                                <div class="line"></div>
                                <h3 class="py-2 text-gray-600 uppercase">@langapp('tags')</h3>
                                @php
                                $data['tags'] = $payment->tags;
                                @endphp
                                @include('partial.tags', $data)

                                <h3 class="py-2 text-gray-600 uppercase">@langapp('notes')</h3>
                                <div class="text-sm prose-lg text-gray-600">
                                    @parsedown($payment->notes)
                                </div>
                                <h3 class="py-2 text-gray-600 uppercase">Meta JSON</h3>

                                @if(!is_null($payment->meta))
                                @foreach ($payment->meta as $key => $value)
                                <div class="mt-2">
                                    <span class="text-gray-600">@icon('solid/caret-right')
                                        {{ $key }}: </span>
                                    <span class="">{{ $value }}</span>
                                </div>
                                @endforeach
                                @endif


                            </div>
                        </div>


                    </div>

                </div>
                {{-- /COLUMN 5 --}}
                <div class="col-lg-7">
                    @include('partial._show_files', ['files' => $payment->files, 'limit' => true])
                    <div class="m-xs"></div>

                    <section class="block comment-list">
                        <article class="comment-item" id="comment-form">
                            <a class="pull-left thumb-sm avatar">
                                <img src="{{ avatar() }}" class="img-circle">
                            </a>
                            <span class="arrow left"></span>
                            <section class="comment-body">
                                <section class="p-2 panel panel-default">
                                    @widget('Comments\CreateWidget', ['commentable_type' => 'payments', 'commentable_id' => $payment->id])
                                </section>
                            </section>
                        </article>

                        @widget('Comments\ShowComments', ['comments' => $payment->comments])
                    </section>

                </div>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>

@push('pagestyle')
@include('stacks.css.wysiwyg')
@endpush

@push('pagescript')
@include('stacks.js.wysiwyg')
@include('comments::_ajax.ajaxify')
@endpush
@endsection