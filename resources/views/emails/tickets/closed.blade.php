@component('mail::message')

# @langmail('tickets.closed.greeting', ['name' => $recipient])

@langmail('tickets.closed.body', ['subject' => $ticket->subject])

@component('mail::button', ['url' => route('tickets.view', $ticket->id)])
@langapp('preview') @langapp('ticket')
@endcomponent

@langmail('tickets.closed.footer')

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ get_option('company_name') }}. All rights reserved.
@endcomponent
@endslot
@endcomponent