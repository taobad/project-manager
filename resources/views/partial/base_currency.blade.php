@if (!$alreadyConsentedWithCurrency)
<div class="alert border-skye-blue-500 border" id="currency-alert">
    <button class="close" data-dismiss="alert" type="button">
        <span>×</span>
        <span class="sr-only">
            Close
        </span>
    </button>
    @langapp('amount_displayed_in_your_cur')
    <a class="text-skye-blue-500 font-bold" href="{{ route('settings.edit', ['section' => 'system']) }}">
        {{ get_option('default_currency') }}
    </a>
</div>

@push('pagescript')
<script>
    $('#currency-alert').on('closed.bs.alert', function() {
        setCookie("acceptCurrency", true, 365);
    });
</script>
@endpush
@endif