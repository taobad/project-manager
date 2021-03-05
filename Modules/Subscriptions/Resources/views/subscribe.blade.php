@extends('layouts.public')
@section('content')
<section id="content" class="details-page public-page">
    <div class="container details-container">
        <section class="vbox">
            <header class="px-2 pb-2 bg-white panel-heading">
                <div class="flex justify-between text-gray-500">
                    <div>
                        <a href="{{route('subscriptions.index')}}" class="btn {{themeButton()}}">@icon('solid/home') @langapp('dashboard')</a>
                    </div>
                </div>
            </header>



            <section class="wrapper panel-default">
                <div class="panel panel-body">

                    @php
                    $data['company'] = auth()->user()->profile->business;
                    $currency = auth()->user()->profile->business->currency;
                    @endphp



                    <div class="row">
                        <div class="col-xs-6">
                            <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('invoice_logo'))  }}" width="{{ get_option('invoice_logo_width')}}px">
                        </div>
                        <div class="text-right col-xs-6">
                            <p class="font20">Subscription #{{ $plan->id}}</p>
                            <div class="estimate-header-text">
                                {{ stripAccents(langapp('date'))  }}
                                : {{ dateTimeFormatted($plan->created_at)}}
                            </div>
                            <div class="estimate-header-text">
                                {{ stripAccents(langapp('billing_date')) }}
                                : {{dateTimeFormatted($plan->billing_date)}}
                            </div>
                        </div>
                    </div>
                    <div class="bg-white well m-t">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="h3">@langapp('client')</p>
                                @include('partial.client_address', $data)
                            </div>
                            <div class="col-xs-6">
                                <p class="h3">@langapp('company_name')</p>
                                @include('partial.company_address', $data)
                            </div>
                        </div>
                    </div>
                    <div class="line"></div>
                    @if(!$subscribed)
                    <div class="checkoutForm">
                        <form action="{{ route('subscriptions.process') }}" id="payment-form" method="POST" class="bs-example form-horizontal">
                            {{csrf_field()}}
                            <input type="hidden" name="plan" value="{{ $plan->stripe_plan_id }}">
                            <input type="hidden" name="name" value="{{ $plan->name }}">
                            <input type="hidden" name="billing_date" value="{{ $plan->billing_date }}">
                            <div class="alert alert-info">
                                @icon('solid/info-circle') Please enter your payment information to complete the payment. You will be charged
                                <strong>{{ formatCurrency($currency, $subscription->amount/100) }}/m</strong>
                            </div>
                            <div class="form-group" style="margin-left: 0px; margin-right: 0px">
                                <label>Card Holders Name @required</label>
                                <input type="text" id="card-holder-name" class="form-control" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div id="card-element"></div>
                            <div id="card-errors" class="m-sm text-danger"></div>
                            <div class="line line-dashed line-lg pull-in"></div>
                            <div class="flex justify-between">
                                <button id="card-button" class="btn process {{themeButton()}}" type="submit" data-secret="{{ $intent->client_secret }}">
                                    @icon('solid/unlock-alt') @langapp('subscribe')
                                </button>

                                <div class="line line-dashed line-lg pull-in"></div>
                            </div>

                        </form>
                    </div>
                    @endif



                    <table class="table">
                        <thead>
                            <tr class="text-uc">
                                <th width="40%">@langapp('product')</th>
                                <th width="10%">@langapp('qty')</th>
                                <th width="15%">@langapp('unit_price')</th>
                                <th width="15%" class="text-right">@langapp('total')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="text-bold">{{ $plan->name }} ({{ formatCurrency(strtoupper($subscription->currency), $subscription->amount / 100) }} /
                                        {{ $subscription->interval }})</span>
                                    <div class="text-gray-600">@parsedown($plan->description)</div>
                                </td>
                                <td>1</td>
                                <td>{{ formatCurrency($currency, $subscription->amount/100) }}</td>
                                <td class="text-right">{{  formatCurrency($currency, $subscription->amount/100) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>@langapp('sub_total') </strong></td>
                                <td class="text-right">{{  formatCurrency($currency, $subscription->amount/100)  }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right no-border">
                                    <strong>@langapp('balance_due') </strong></td>
                                <td class="text-right text-bold">{{  formatCurrency($currency, $subscription->amount/100)  }}</td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
    </div>
</section>
@push('pagescript')
<script src="https://js.stripe.com/v3/"></script>
<script>
    var style = {
base: {
    color: '#32325d',
    lineHeight: '18px',
    fontFamily: '{{ get_option('system_font') }}, Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
        color: '#aab7c4'
    }
},
invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};
const stripe = Stripe('{{ config('cashier.key') }}', { locale: '{{ get_option('locale') }}' });
const elements = stripe.elements();
const cardElement = elements.create('card', { style: style });
const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;
cardElement.mount('#card-element');
cardElement.addEventListener('change', function(event) {
var displayError = document.getElementById('card-errors');
if (event.error) {
    displayError.textContent = event.error.message;
} else {
    displayError.textContent = '';
}
});
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();
    $(".process").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
    stripe.handleCardSetup(clientSecret, cardElement, {
        payment_method_data: {
        }
    })
    .then(function(result) {
    if (result.error) {
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;
        toastr.error(result.error.message , '@langapp('response_status') ');
        $(".process").html('Try again');
    } else {
        stripeTokenHandler(result.setupIntent.payment_method);
    }
    });
});
function stripeTokenHandler(paymentMethod) {
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'paymentMethod');
    hiddenInput.setAttribute('value', paymentMethod);
    form.appendChild(hiddenInput);
    form.submit();
}
</script>
@endpush
@endsection