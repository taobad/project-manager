@if (!$alreadyConsentedWithCurrency)
<div class="alert bg-indigo-100 border-indigo-600 border" id="currency-alert">
    <button class="close" data-dismiss="alert" type="button">
        <span>×</span>
        <span class="sr-only">
            Close
        </span>
    </button>
    @langapp('amount_displayed_in_your_cur')
    <a class="text-indigo-600 font-bold" href="{{ route('settings.edit', ['section' => 'system']) }}">
        {{ get_option('default_currency') }}
    </a>
</div>

@push('pagescript')
<script>
    $('#currency-alert').on('closed.bs.alert', function () {
            setCookie("acceptCurrency", true, 365);
        });
</script>
@endpush
@endif