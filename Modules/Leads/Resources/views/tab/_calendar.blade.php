<div class="col-md-12">
    <section class="panel panel-default b-top">
        <header class="panel-heading h3">

            @can('events_create')

            <a href="{{ route('calendar.create', ['module' => 'leads', 'id' => $lead->id]) }}" class="btn {{themeButton()}} pull-right" data-toggle="ajaxModal">
                @icon('solid/calendar-plus') @langapp('schedule_event') </a>
            @endcan

            @icon('solid/calendar-alt') @langapp('calendar')
        </header>

        <section class="panel panel-body">

            <div class="calendar" id="appointments"></div>
        </section>


    </section>
</div>

@push('pagestyle')
@include('stacks.css.fullcalendar')
@endpush

@push('pagescript')
@include('stacks.js.fullcalendar')

<script type="text/javascript">
    $(document).ready(function () {

        var calendarEl = document.getElementById('appointments');
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
                        @foreach ($lead->schedules as $key => $event) 
                        {
                            title: '{{ addslashes($event->event_name) }}',
                            start: '{{  date('Y-m-d H:i', strtotime($event->start_date))  }}',
                            end: '{{  date('Y-m-d H:i', strtotime($event->end_date))  }}',
                            url: '{{  route('calendar.view', ['entity' => $event->id, 'module' => 'events'])  }}',
                            description: '{{ $event->description }}',
                            type: 'fo',
                            color: '{{ $event->color }}'
                        },
                        @endforeach
                    ],
                    color: '#7266BA',
                    textColor: 'white'
                },
                {
                    events: [
                        @foreach ($lead->todos as $activity) 
                        {
                            title: '{{ addslashes($activity->subject) }}',
                            start: '{{  date('Y-m-d H:i:s', strtotime($activity->due_date))  }}',
                            end: '{{  date('Y-m-d H:i:s', strtotime($activity->due_date))  }}',
                            url: '{{  route('todo.edit', $activity->id)  }}',
                            description: '{{ $activity->subject }} due date',
                            type: 'fo',
                            color: '#{{ $activity->completed === 1 ? 'ea2e49' : '22b66e' }}',
                        },
                        @endforeach
                    ],
                    textColor: 'white'
                }
            ]
        });
        calendar.render();
    });
</script>
@endpush