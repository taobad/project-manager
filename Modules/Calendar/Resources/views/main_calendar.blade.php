<script type="text/javascript">
    $(document).ready(function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale: '{{calendarLocale()}}',
          buttonText: {
            today:    '{{langapp('today')}}',
            month:    '{{langapp('month')}}',
            week:     '{{langapp('week')}}',
            day:      '{{langapp('day')}}',
          },
          googleCalendarApiKey: '{{ get_option('gcal_api_key') }}',
          headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            nowIndicator: true,
            dateClick: function(info) {

            },
            eventDidMount: function (info) {
                $(info.el).tooltip({title:info.event.extendedProps.description, container: "body"});
                if (info.event.extendedProps.type == 'fo') {
                    $(info.el).attr('data-toggle', 'ajaxModal').addClass('ajaxModal');
                }
            },
            
            eventClick: function(info) {
                if (info.event.extendedProps.type != 'fo') {
                    window.open(info.event.url, '_blank', 'width=700,height=600');
                    info.jsEvent.preventDefault();
                }
            },
            eventSources: [
                {
                    events: [
                        @foreach (Auth::user()->schedules->where('calendar_id', activeCalendar()) as $event) 
                        {
                            title: '{{ addslashes($event->event_name) }}',
                            start: '{{ date('Y-m-d H:i:s', strtotime($event->start_date)) }}',
                            end: '{{ date('Y-m-d H:i:s', strtotime($event->end_date)) }}',
                            url: '{{ $event->url }}',
                            description: '{{ $event->description }}',
                            type: 'fo',
                            allDay: false,
                            color: '{{ $event->color }}'
                        },
                        @endforeach
                        @if(!isAdmin() && Auth::user()->profile->company > 0)
                        @foreach (Auth::user()->profile->business->invoices as $inv) 
                        {
                            title: '{{ addslashes($inv->name) }}',
                            start: '{{ date('Y-m-d H:i:s', strtotime($inv->due_date)) }}',
                            end: '{{ date('Y-m-d H:i:s', strtotime($inv->due_date)) }}',
                            url: '{{ route('invoices.view', $inv->id) }}',
                            description: '{{ $inv->reference_no }} due',
                            type: 'fo',
                            allDay: false,
                            color: '#545caf'
                        },
                        @endforeach

                        @foreach (Auth::user()->profile->business->estimates as $est) 
                        {
                            title: '{{ addslashes($est->name) }}',
                            start: '{{ date('Y-m-d H:i:s', strtotime($est->due_date)) }}',
                            end: '{{ date('Y-m-d H:i:s', strtotime($est->due_date)) }}',
                            url: '{{ route('estimates.view', $est->id) }}',
                            description: '{{ $est->reference_no }} due',
                            type: 'fo',
                            allDay: false,
                            color: '#4a68f8'
                        },
                        @endforeach

                        @foreach (Auth::user()->profile->business->contracts as $contract) 
                        {
                            title: '{{ addslashes($contract->contract_title) }}',
                            start: '{{ date('Y-m-d H:i:s', strtotime($contract->expiry_date)) }}',
                            end: '{{ date('Y-m-d H:i:s', strtotime($contract->expiry_date)) }}',
                            url: '{{ route('contracts.view', $contract->id) }}',
                            description: '{{ $contract->company->name }} contract',
                            type: 'fo',
                            allDay: false,
                            color: '#00d65f'
                        },
                        @endforeach

                        @foreach (Auth::user()->profile->business->payments as $payment) 
                        {
                            title: '{{ addslashes($payment->code) }}',
                            start: '{{ date('Y-m-d H:i:s', strtotime($payment->payment_date)) }}',
                            end: '{{ date('Y-m-d H:i:s', strtotime($payment->payment_date)) }}',
                            url: '{{ route('invoices.view', $payment->invoice_id) }}',
                            description: '{{ $payment->amount_formatted }} received',
                            type: 'fo',
                            allDay: false,
                            color: '#f43445'
                        },
                        @endforeach

                        @foreach (Auth::user()->profile->business->projects as $project) 
                        {
                            title: '{{ addslashes($project->name) }}',
                            start: '{{ date('Y-m-d H:i:s', strtotime($project->due_date)) }}',
                            end: '{{ date('Y-m-d H:i:s', strtotime($project->due_date)) }}',
                            url: '{{ route('projects.view', $project->id) }}',
                            description: '{{ str_limit($project->description,25) }}',
                            type: 'fo',
                            allDay: false,
                            color: '#0772d1'
                        },
                        @endforeach

                        @endif
                    ],
                    color: '#38354a',
                    textColor: 'white'
                },
                {
                    googleCalendarId: '{{ get_option('gcal_id') }}',
                    color: '#1a73e8',
                }
            ]
        });
        calendar.render();
    });
</script>