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
<p>
    For bank payments, use the Account Details below;
</p>
<div class="p-3 m-2 font-semibold leading-6 text-gray-600 bg-indigo-100 rounded-md">
    @parsedown(get_option('bank_details'))
</div>

@if (settingEnabled('partial_payments'))
<h3 class="h3 bt font14">@langapp('select_payment_amount')</h3>
<div class="text-gray-600 m-sm">@langapp('choose_from_available_options')</div>
<div class="m-2">
    @langapp('minimum_payment_due')
    <strong class="pull-right">{{ formatCurrency($cur['code'], $nextInstallment) }}</strong>
    <div class="text-gray-600 m-l-md">@langapp('pay_minimum_amount')</div>
</div>
@endif

<div class="m-2">
    @langapp('full_amount')
    <strong class="pull-right">{{ formatCurrency($cur['code'], $due) }}</strong>
    <div class="text-gray-600 m-l-md">@langapp('pay_full_amount').</div>
</div>

@if (settingEnabled('partial_payments'))
<div class="m-xs">
    @langapp('other_amount')
    <div class="text-gray-600 m-l-md">@langapp('pay_any_amount')</div>
</div>
@endif

<x-alert type="warning" icon="solid/info-circle" class="m-2 text-sm leading-5">
    We will notify you when we receive your payment.
</x-alert>


<div class="modal-footer">
    <a href="#" class="btn {{themeButton()}}" data-dismiss="modal">@langapp('close')</a>
</div>