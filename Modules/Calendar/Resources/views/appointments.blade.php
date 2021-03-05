@extends('layouts.app')

@section('content')

<section id="content">
    <section class="hbox stretch">

        <aside>
            <section class="vbox">
                <header class="bg-white header b-b b-light">

                    @if (isAdmin() || can('events_create'))
                    <a href="{{ route('calendar.create.appointment') }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                        @icon('solid/calendar-plus') @langapp('add_appointment')</a>

                    @endif


                </header>
                <section class="scrollable wrapper bg">

                    <div class="appointments" id="appointments"></div>

                </section>

            </section>
        </aside>

    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>

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
                        @foreach (Auth::user()->appointments as $event) 
                        {
                            title: '{{ addslashes($event->name) }}',
                            start: '{{ date('Y-m-d H:i:s', strtotime($event->start_time)) }}',
                            end: '{{ date('Y-m-d H:i:s', strtotime($event->finish_time)) }}',
                            url: '/calendar/appointments/view/{{ $event->id }}',
                            description: 'Venue: {{ $event->venue }}',
                            type: 'fo',
                            allDay: false,
                            color: '#ca7171'
                        },
                        @endforeach
                    ],
                    color: '#38354a',
                    textColor: 'white'
                },
                {
                    googleCalendarId: '{{ get_option('gcal_id') }}'
                }
            ]
        });
        calendar.render();

    });
</script>
@endpush

@endsection