@component('mail::message')

# @langmail('tickets.status.greeting', ['name' => $recipient])

@langmail('tickets.status.body', ['subject' => $ticket->subject, 'status' => $ticket->AsStatus->status])


[@langapp('preview') @langapp('ticket')]({{route('tickets.view', $ticket->id)}})  

@langmail('tickets.status.footer', ['company' => get_option('company_name')])

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ get_option('company_name') }}. All rights reserved.
@endcomponent
@endslot
@endcomponent