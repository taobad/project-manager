<form action="{{ route('payments.2checkout.checkout') }}" class="bs-example form-horizontal" id="payment-form" method="POST">
    {{ csrf_field() }}

    @include('payments::_includes._options')

    <div class="m-2">

        <x-alert type="success" icon="solid/info-circle" class="text-sm leading-5">
            @langapp('card_store_notice')
        </x-alert>

        <input id="token" name="token" type="hidden" value="" />
        <input type="hidden" id="tokenAmount" name="amt" value="{{ $invoice->due() }}" />
        <input id="name" name="name" type="hidden" value="{{ Auth::check() ? Auth::user()->name : optional($invoice->company->contact)->name }}" />
        {{-- For testing use name John Doe --}}
        <input id="billingAddr" name="billingAddr" type="hidden" value="{{ $invoice->company->billing_street }}" />

        <h3 class="text-xl text-gray-600">@langapp('payment_settings')</h3>

        <div id="card-element"></div>

        <div class="modal-footer">
            <a href="#" class="btn {{themeButton()}}" data-dismiss="modal">@langapp('close')</a>
            <button type="submit" class="btn {{themeButton()}} pay-btn" id="checkout-submit">@langapp('pay_invoice') via 2Checkout</button>
        </div>

    </div>

</form>


@push('pagescript')

<script>
    $("#amount").change(function () {
        if ($("#amount").val() > {{$invoice->due()}})
        setPayButtonDisableState(true);
        else {
        setPayButtonDisableState(false);
        }
    });

    var amount = 0;
    var amt = $('input[name=amount]').val();
    $("#tokenAmount").val(amt);
    var id = $('input[name=id]').val();
    var payment = $('input[name="payment"]:checked', '#payment-form').val();
    var amount = getAmount(id, amt, payment).then(function(amount) {
        $("#tokenAmount").val(amount);
        $("#payment").val(payment);
    });
    

    $(document).ready(function () {
    let jsPaymentClient = new TwoPayClient("{{config('services.2checkout.merchantCode')}}");
    let component = jsPaymentClient.components.create('card');
    component.mount('#card-element');
    document.getElementById('payment-form').addEventListener('submit', (event) => {
        $(".pay-btn").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
        setPayButtonDisableState(true);
        event.preventDefault();
        const billingDetails = {
            name: document.querySelector('#name').value
        };
    jsPaymentClient.tokens.generate(component, billingDetails).then((response) => {
        document.getElementById('token').value=response.token; 
        $(".process").html('Submitting..<i class="fas fa-spin fa-spinner"></i>');
        document.getElementById('payment-form').submit();
        setPayButtonDisableState(false);
    }).catch((error) => {
        toastr.error('Sorry! Request to 2checkout payment failed.', '@langapp('response_status') ');
        console.error(error);
    });
  });
});

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

function setPayButtonDisableState(newState) {
    var payButton = document.getElementById("checkout-submit");
    payButton.disabled = newState;
    var buttonContent = payButton.innerHTML;
    payButton.innerHTML = buttonContent;
}
</script>
@endpush

@stack('pagescript')