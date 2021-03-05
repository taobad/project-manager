<div class="panel-body">

    <form action="{{ route('payments.gocardless.redirect') }}" class="bs-example form-horizontal" id="gocardless-form" method="POST">
        {{ csrf_field() }}

        @include('payments::_includes._options')

        <x-alert type="warning" icon="solid/info-circle" class="text-sm leading-5">
            Once this is setup, you won't need to pay each invoice manually, your future invoices will be paid automatically.
        </x-alert>

        <h1 id="error"></h1>


        <div class="modal-footer">
            <a href="#" class="btn {{themeButton()}}" data-dismiss="modal">@langapp('close')</a>
            <button type="submit" class="btn {{themeButton()}} pay-btn" id="pay-submit">@langapp('pay_invoice') via Gocardless</button>
        </div>


    </form>

</div>

<script>
    $(document).ready(function () {
        $("#amount").change(function () {
        if ($("#amount").val() > {{$invoice->due()}})
            $('#pay-submit').attr('disabled', 'disabled');
        else {
            $('#pay-submit').removeAttr('disabled');
        }
        });

        $('#pay-submit').click(function (event) {
            $(".pay-btn").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
            var formData = {
                'id': $('input[name=id]').val(),
                'amount': $('input[name=amount]').val(),
                'payment': $('input[name="payment"]:checked', '#gocardless-form').val()
            };

            axios.post('{{ route('payments.checkout') }}', formData)
                .then(function (response) {
                    $('input[name="amount"]').val(response.data.amount);
                    var amount = document.querySelector('input[name=amount]').value;
                    $(".pay-btn").html('Redirecting..<i class="fas fa-spin fa-spinner"></i>');
                    axios.post('{{ route('payments.gocardless.redirect') }}', formData)
                        .then(function (response) {
                            window.location.href = response.data.url;
                        })
                        .catch(function (error) {
                            toastr.error('Oops! Creating redirect flow failed!', '@langapp('response_status') ');
                    });
            })
                .catch(function (error) {
                    toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
            });
            event.preventDefault();
        });

    });
</script>