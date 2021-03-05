<!-- Begin Payment Form -->
<form class="bs-example form-horizontal SqPaymentForm" method="POST" id="nonce-form" action="{{ route('square.checkout') }}">
  {{ csrf_field() }}
  @include('payments::_includes._options')

  <div class="line line-dashed"></div>
  <x-alert type="success" icon="solid/info-circle" class="text-sm leading-5">
    @langapp('card_store_notice'). Payment will be processed via Square, Inc
  </x-alert>

  <div id="form-container">
    <div id="sq-card-number"></div>
    <div class="third" id="sq-expiration-date"></div>
    <div class="third" id="sq-cvv"></div>
    <div class="third" id="sq-postal-code"></div>

    <input type="hidden" id="card-nonce" name="nonce">
    <input type="hidden" id="idempotency_key" name="idempotency_key">
    <input type="hidden" id="tokenAmount" name="amt" value="{{ $invoice->due() }}" />

  </div>
  <div id="error" role="alert"></div>

  <div class="modal-footer sq-field">
    <a href="#" class="btn {{themeButton()}}" data-dismiss="modal">@langapp('close')</a>
    <button type="submit" id="sq-creditcard" onclick="onGetCardNonce(event)" class="sq-button btn {{themeButton()}} process">
      <i class="far fa-check-circle"></i> {{ langapp('pay_invoice') }} via Square
    </button>
  </div>
</form>

<style>
  .third {
    width: calc((100% - 32px) / 3);
    padding: 0;
    margin: 0 6px 6px 0;
  }

  .third:last-of-type {
    margin-right: 0;
  }

  .sq-input {
    height: 40px;
    box-sizing: border-box;
    border: 1px solid #E0E2E3;
    background-color: white;
    border-radius: 6px;
    display: inline-block;
    -webkit-transition: border-color .2s ease-in-out;
    -moz-transition: border-color .2s ease-in-out;
    -ms-transition: border-color .2s ease-in-out;
    transition: border-color .2s ease-in-out;
  }

  .sq-input--focus {
    border: 1px solid #4A90E2;
  }

  .sq-input--error {
    border: 1px solid #E02F2F;
  }

  #sq-card-number {
    margin-bottom: 8px;
  }
</style>

<script type="text/javascript">
  var amount = 0;
  var amt = $('input[name=amount]').val();
  $("#tokenAmount").val(amt);
  var id = $('input[name=id]').val();
  var payment = $('input[name="payment"]:checked', '#nonce-form').val();
  var amount = getAmount(id, amt, payment).then(function(amount) {
      $("#tokenAmount").val(amount);
      $("#payment").val(payment);
  });
  const idempotency_key = uuidv4();
  const paymentForm = new SqPaymentForm({
       applicationId: "{{ config('services.square.app_id') }}",
       locationID: "{{ config('services.square.location_id') }}",
       inputClass: 'sq-input',
       autoBuild: false,
       inputStyles: [{
           fontSize: '14px',
           lineHeight: '24px',
           padding: '8px',
           placeholderColor: '#a0a0a0',
           backgroundColor: 'transparent',
       }],
     cardNumber: {
         elementId: 'sq-card-number',
         placeholder: 'Card Number'
     },
     cvv: {
         elementId: 'sq-cvv',
         placeholder: 'CVV'
     },
     expirationDate: {
         elementId: 'sq-expiration-date',
         placeholder: 'MM/YY'
     },
     postalCode: {
         elementId: 'sq-postal-code',
         placeholder: 'Postal'
     },
     callbacks: {
         cardNonceResponseReceived: function (errors, nonce, cardData) {
          if (errors){
          var error_html = "";
          for (var i =0; i < errors.length; i++){ 
            error_html +="<li> " + errors[i].message + " </li>" ; 
          } 
            document.getElementById("error").innerHTML=error_html;
            setPayButtonDisableState(false);
            return; 
          }else{ 
            document.getElementById("error").innerHTML="" ;
          }
          document.getElementById('card-nonce').value=nonce; 
          document.getElementById('idempotency_key').value=idempotency_key; 
          
          $(".process").html('Submitting..<i class="fas fa-spin fa-spinner"></i>');
          document.getElementById('nonce-form').submit();
          setPayButtonDisableState(false);
           }
         }
     });
     paymentForm.build();

     function onGetCardNonce(event) {
        $(".process").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
        setPayButtonDisableState(true);
        event.preventDefault();
        paymentForm.requestCardNonce(); 
     }
     function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
          var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
          return v.toString(16);
        });
     }
     function setPayButtonDisableState(newState) {
        var payButton = document.getElementById("sq-creditcard");
        payButton.disabled = newState;
        var buttonContent = payButton.innerHTML;
        payButton.innerHTML = buttonContent;
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