<form action="" class="bs-example form-horizontal" id="razorpay-form" method="POST">
    {{ csrf_field() }}


    @include('payments::_includes._options')


    <div class="modal-footer">
        <a href="#" class="btn {{themeButton()}}" data-dismiss="modal">@langapp('close')</a>
        <button type="submit" class="btn {{themeButton()}} pay-btn" id="razorpay-submit">@langapp('pay_invoice') via RazorPay</button>
    </div>


</form>


@push('pagescript')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    $('#razorpay-submit').click(function (event) {
            $(".pay-btn").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
            var formData = {
                'id': $('input[name=id]').val(),
                'amount': $('input[name=amount]').val(),
                'payment': $('input[name="payment"]:checked', '#razorpay-form').val()
            };
            axios.post('{{ route('payments.checkout') }}', formData)
                .then(function (response) {
                    $(".pay-btn").html('<i class="fas fa-sync"></i> Redirecting..</span>');
                    $('input[name="amount"]').val(response.data.amount);
                    var options = {
                        "key": "{{ config('services.razorpay.keyId') }}",
                        "amount": response.data.razorpay.amount,
                        "name": "{{ config('company_name') }}",
                        "description": "Payment for Invoice "+response.data.razorpay.reference_no,
                        "image": "{{ getStorageUrl(config('system.media_dir').'/'.get_option('company_logo')) }}",
                        "handler": function (res){
                            $(".pay-btn").html('<i class="fas fa-sync-alt fa-spin"></i> Processing, Please Wait</span>');
                            axios.post('{{ route('razorpay.capture') }}', {
                                'id' : res.razorpay_payment_id,
                                'amount': response.data.razorpay.amount
                            }).then(function (response) {
                                toastr.success(response.data.message, '@langapp('response_status') ');
                                window.location.href = response.data.redirect;
                            }).catch(function (error) {
                                toastr.error('Razorpay failed, please contact admin', '@langapp('response_status') ');

                            });
                        },
                        "prefill": {
                            "name": "{{ Auth::check() ? Auth::user()->name : optional($invoice->company->contact)->name }}",
                            "email": "{{ Auth::check() ? Auth::user()->email : optional($invoice->company->contact)->email }}",
                            "contact": "{{ Auth::check() ? Auth::user()->profile->phone : optional($invoice->company->contact->profile)->phone }}"
                        },
                        "notes": {
                            "currency": response.data.razorpay.currency,
                            "invoice_id" : response.data.razorpay.invoice_id,
                            "amount" : response.data.amount
                        },
                        "theme": {
                            "color": "#F37254"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
            })
                .catch(function (error) {
                    toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
            });
            event.preventDefault();
        });
</script>
@endpush
@stack('pagescript')