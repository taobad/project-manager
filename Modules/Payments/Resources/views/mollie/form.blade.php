<form action="{{ route('payments.mollie.checkout') }}" class="bs-example form-horizontal" id="mollie-form" method="POST">
    {{ csrf_field() }}
    <x-alert type="warning" icon="solid/info-circle" class="text-sm leading-5">
        @langapp('card_store_notice')
    </x-alert>

    @include('payments::_includes._options')




    <div class="modal-footer">
        <a href="#" class="btn {{themeButton()}}" data-dismiss="modal">@langapp('close')</a>
        <button type="submit" class="btn {{themeButton()}} pay-btn" id="mollie-submit">@langapp('pay_invoice') via Mollie</button>
    </div>


</form>




<script>
    $(document).ready(function () {
        $("#amount").change(function () {
        if ($("#amount").val() > {{$invoice->due()}})
            $('#mollie-submit').attr('disabled', 'disabled');
        else {
            $('#mollie-submit').removeAttr('disabled');
        }
        });

        $('#mollie-submit').click(function (event) {
            $(".pay-btn").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
            var formData = {
                'id': $('input[name=id]').val(),
                'amount': $('input[name=amount]').val(),
                'payment': $('input[name="payment"]:checked', '#mollie-form').val()
            };

            axios.post('{{ route('payments.checkout') }}', formData)
                .then(function (response) {
                    $('input[name="amount"]').val(response.data.amount);
                    $(".pay-btn").html('<i class="fas fa-sync"></i> Redirecting..</span>');
                    $("#mollie-form").submit();
            })
                .catch(function (error) {
                    toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
            });
            event.preventDefault();
        });

    });
</script>