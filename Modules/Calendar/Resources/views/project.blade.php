<script type="text/javascript">
    $(document).ready(function () {

        var calendarEl = document.getElementById('cal');
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
                        @foreach ($project->tasks as $key => $task)
                        {
                            title: '{{ addslashes($task->name) }}',
                            start: '{{ date('Y-m-d', strtotime($task->due_date)) }}',
                            end: '{{ date('Y-m-d', strtotime($task->due_date)) }}',
                            url: '{{ route('calendar.view', ['entity' => $task->id, 'module' => 'tasks']) }}',
                            description: '{{$task->name}} due date',
                            type: 'fo',
                            color: '#3869D4'
                        },
                        @endforeach
                        @foreach ($project->schedules as $event)
                        {
                            title: '{{ addslashes($event->event_name) }}',
                            start: '{{ date('Y-m-d', strtotime($event->start_date))  }}',
                            end: '{{  date('Y-m-d', strtotime($event->end_date))  }}',
                            url: '{{  route('calendar.view', ['entity' => $event->id, 'module' => 'events'])  }}',
                            description: '{{$event->description}}',
                            type: 'fo',
                            color: '{{ $event->color }}'
                        },
                        @endforeach
                    ],
                    color: '#7266BA',
                    textColor: 'white'
                }
            ]
        });
        calendar.render();

    });
</script>