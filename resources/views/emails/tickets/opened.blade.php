@component('mail::message')

# @langmail('tickets.opened.greeting', ['name' => $recipient])

@langmail('tickets.opened.body', ['subject' => $ticket->subject])  

[@langapp('preview') @langapp('ticket')]({{route('tickets.view', $ticket->id)}})  

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ get_option('company_name') }}. All rights reserved.
@endcomponent
@endslot
@endcomponent