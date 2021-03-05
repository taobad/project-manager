<form class="bs-example form-horizontal" onsubmit="return false" id="stripe-form">

  @include('payments::_includes._options')

  <input type="hidden" id="payment" name="payment">

  <input type="hidden" id="tokenAmount" name="amt" value="{{ $invoice->due() }}" />

  <div class="line line-dashed"></div>
  <x-alert type="success" icon="solid/info-circle" class="text-sm leading-5">
    @langapp('card_store_notice')
  </x-alert>

  <div class="form-row">
    <label for="card-element">
      Card Holders Name @required
    </label>
    <input id="cardholder-name" class="form-control" value="{{ Auth::check() ? Auth::user()->name : optional($invoice->company->contact)->name }}" type="text">
    <div id="card-element" class="m-sm"></div>

  </div>

  <div id="card-errors" role="alert"></div>



  <div class="modal-footer">
    <a href="#" class="btn btn-default" data-dismiss="modal">@langapp('close')</a>
    <button type="submit" id="card-button" class="btn btn-success process">
      <i class="fas fa-receipt"></i> {{ langapp('pay_invoice') }}
    </button>
  </div>
</form>

<script>
  var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
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

var elements = stripe.elements();

var cardElement = elements.create('card', {style: style});
cardElement.mount('#card-element');
var cardholderName = document.getElementById('cardholder-name');
var cardButton = document.getElementById('card-button');

cardButton.addEventListener('click', function(ev) {
    $(".process").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
      var amount = 0;
      var amt = $('input[name=amount]').val();
      $("#tokenAmount").val(amt);
      var id = $('input[name=id]').val();
      var payment = $('input[name="payment"]:checked', '#stripe-form').val();
      var amount = getAmount(id, amt, payment).then(function(amount) {
            $("#tokenAmount").val(amount);
            $("#payment").val(payment);
        });

  stripe.createPaymentMethod('card', cardElement, {
    billing_details: {
      name: cardholderName.value,
      email: "{{ $invoice->company->email }}",
      address: {
        city: "{{ $invoice->company->billing_city }}",
        country: "{{ \App\Entities\Country::select('code')->where('name', $invoice->company->billing_country)->first()->code }}",
        line1: "{{ $invoice->company->billing_street }}",
        postal_code: $('input[name=postal]').val(),
        state: "{{ $invoice->company->billing_state }}",
      }
    }
  }).then(function(result) {
    if (result.error) {
      toastr.error(result.error.message , '@langapp('response_status') ');
      $(".process").html('Try again');
    } else {
      fetch('{{ route('payments.stripe.intent') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            payment_method_id: result.paymentMethod.id,
            amount: document.getElementById('tokenAmount').value,
            payment: payment,
            currency: '{{ $invoice->currency }}',
            id: id,
            _token: '{{ csrf_token() }}'
        })
      }).then(function(result) {
        result.json().then(function(json) {
          handleServerResponse(json);
        })
      });
    }
  });
});

function handleServerResponse(response) {
  if (response.error) {
    toastr.error(response.error , '@langapp('response_status') ');
    $(".process").html('Try again');
  } else if (response.requires_action) {
    stripe.handleCardAction(
      response.payment_intent_client_secret
    ).then(function(result) {
      if (result.error) {
        toastr.error(result.error.message , '@langapp('response_status') ');
        $(".process").html('Try again');
      } else {
        fetch('{{ route('payments.stripe.intent') }}', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ 
            payment_intent_id: result.paymentIntent.id,
            id: '{{ $invoice->id }}',
            _token: '{{ csrf_token() }}'
        })
        }).then(function(confirmResult) {
          return confirmResult.json();
        }).then(handleServerResponse);
      }
    });
  } else {
    toastr.success('@langapp('payment_processing')' , '@langapp('response_status') ');
    window.location.href = response.redirect;
    
  }
}
    function getAmount(id, amt, payment) {
        var formData = {
            'id': id,
            'amount': amt,
            'payment': payment
        };
        var new_amount = 0;
        return axios.post('{{ route('payments.checkout') }}', formData)
                .then(function (response) {
                    this.response = response.data;
                    return this.response.amount;
            })
            .catch(function (error) {
                toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
            });
    }

</script>