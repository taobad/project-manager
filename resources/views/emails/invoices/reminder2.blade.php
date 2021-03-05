@component('mail::message')
@langmail('invoices.reminder.reminder2.greeting', ['name' => $invoice->company->primary_contact > 0 ? $invoice->company->contact_person : $invoice->company->name])  
@langmail('invoices.reminder.reminder2.body', [
	'code' => $invoice->reference_no, 'date' => $invoice->due_date->toDayDateTimeString(),
	'balance' => formatCurrency($invoice->currency, $invoice->due())
	])

@component('mail::button', ['url' => url()->signedRoute('invoices.guest', $invoice->id), 'color' => 'blue'])
@langapp('preview') @langapp('invoice')
@endcomponent

{!! get_option('email_signature') !!}

@endcomponent