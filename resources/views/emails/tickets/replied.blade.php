@component('mail::message')

# @langmail('tickets.replied.greeting', ['name' => $recipient])

@langmail('tickets.replied.body', ['code' => $ticket->code, 'subject' => $ticket->subject])

@component('mail::panel')
{!! $comment->message !!}
@endcomponent

@langmail('tickets.replied.footer')

@component('mail::button', ['url' => route('tickets.view', $ticket->id)])
@langapp('preview') @langapp('ticket')
@endcomponent

@endcomponent