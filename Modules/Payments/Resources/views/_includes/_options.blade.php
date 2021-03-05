<?php
$cur = array_first(
    currencies(),
    function ($cur) use ($invoice) {
        return $cur['code'] == $invoice->currency;
    }
);
$nextInstallment = $invoice->nextUnpaidPartial();
$installment = $invoice->nextUnpaidPartial(false);
$due = $invoice->due();
?>

<?php
$payment_id = $invoice->payments()->max('id');
if ($payment_id > 0) {
    $lastPayment = Modules\Payments\Entities\Payment::find($payment_id);
    $lastPaymentCur = array_first(
        currencies(),
        function ($cur) use ($lastPayment) {
            return $cur['code'] == $lastPayment->currency;
        }
    );
}
?>
<div class="m-2 row">
    <div class="border-r col-sm-6">
        @icon('solid/calendar-alt')
        <span class="bt">@langapp('minimum_payment_due')</span><br />
        in {{ dueInDays($installment->due_date) }} @langapp('days') on {{ dateFormatted($installment->due_date) }}
    </div>
    <div class="col-sm-6">
        @icon('solid/check-circle')
        <span class="bt">@langapp('last_payment')</span><br />

        @if (isset($lastPayment))
        {{ formatCurrency($lastPaymentCur['code'], $lastPayment->amount) }} received on {{ dateFormatted($lastPayment->payment_date) }}
        @else
        {{ formatCurrency($cur['code'], 0.00) }} (@langapp('no_records'))
        @endif

    </div>
</div>

<div class="border-t row">
    <input type="hidden" name="id" value="{{ $invoice->id }}">
    @if (!settingEnabled('partial_payments'))
    <input id="amount" type="hidden" value="{{ $due }}" name="amount">
    @endif

    <div class="col-sm-12 m-t-sm">
        @if (settingEnabled('partial_payments'))
        <h3 class="h3 bt font14">@langapp('select_payment_amount')</h3>
        <div class="text-muted m-sm">@langapp('choose_from_available_options')</div>

        <div class="minimum">
            <label>
                <input type="radio" name="payment" {{ settingEnabled('partial_payments') ? '' : 'disabled' }} value="minimum" />
                <span class="label-text">@langapp('minimum_payment_due')</span>
            </label>
            <strong class="pull-right">{{ formatCurrency($cur['code'], $nextInstallment) }}</strong>
            <div class="text-muted m-l-md">@langapp('pay_minimum_amount')</div>
        </div>
        @endif


        <div class="full_amount">

            <label>
                <input type="radio" name="payment" value="full" checked />
                <span class="label-text">@langapp('full_amount')</span>
            </label>


            <strong class="pull-right">{{ formatCurrency($cur['code'], $due) }}</strong>
            <div class="text-muted m-l-md">@langapp('pay_full_amount')</div>
        </div>

        @if (settingEnabled('partial_payments'))
        <div class="other">

            <label>
                <input type="radio" name="payment" {{ settingEnabled('partial_payments') ? '' : 'disabled' }} value="other" />
                <span class="label-text">@langapp('other_amount')</span>
            </label>
            <div class="col-lg-4 pull-right">
                <div class="input-group"><span class="input-group-addon">{{ $cur['symbol'] }}</span>
                    <input class="form-control money" id="amount" type="text" value="{{ $due }}" name="amount" {{ settingEnabled('partial_payments') ? '' : 'disabled' }}>
                </div>
            </div>
            <div class="col-lg-8">
                <span class="text-muted">@langapp('pay_any_amount')</span>
            </div>

        </div>
        @endif

    </div>
</div>
<script>
    $('.money').maskMoney({allowZero: true, thousands: ''});
</script>