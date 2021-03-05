<?php $__env->startSection('content'); ?>

<section id="content">
    <section class="hbox stretch">

        <aside>
            <section class="vbox">
                <header class="bg-white header b-b b-light">

                    <?php if(isAdmin() || can('events_create')): ?>
                    <a href="<?php echo e(route('calendar.create.appointment')); ?>" data-toggle="ajaxModal" class="btn <?php echo e(themeButton()); ?>">
                        <?php echo e(svg_image('solid/calendar-plus')); ?> <?php echo trans('app.'.'add_appointment'); ?></a>

                    <?php endif; ?>


                </header>
                <section class="scrollable wrapper bg">

                    <div class="appointments" id="appointments"></div>

                </section>

            </section>
        </aside>

    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>

<?php $__env->startPush('pagestyle'); ?>
<?php echo $__env->make('stacks.css.fullcalendar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.fullcalendar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        var calendarEl = document.getElementById('appointments');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale: '<?php echo e(calendarLocale()); ?>',
          buttonText: {
            today:    '<?php echo e(langapp('today')); ?>',
            month:    '<?php echo e(langapp('month')); ?>',
            week:     '<?php echo e(langapp('week')); ?>',
            day:      '<?php echo e(langapp('day')); ?>',
          },
          googleCalendarApiKey: '<?php echo e(get_option('gcal_api_key')); ?>',
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
                        <?php $__currentLoopData = Auth::user()->appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        {
                            title: '<?php echo e(addslashes($event->name)); ?>',
                            start: '<?php echo e(date('Y-m-d H:i:s', strtotime($event->start_time))); ?>',
                            end: '<?php echo e(date('Y-m-d H:i:s', strtotime($event->finish_time))); ?>',
                            url: '/calendar/appointments/view/<?php echo e($event->id); ?>',
                            description: 'Venue: <?php echo e($event->venue); ?>',
                            type: 'fo',
                            allDay: false,
                            color: '#ca7171'
                        },
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ],
                    color: '#38354a',
                    textColor: 'white'
                },
                {
                    googleCalendarId: '<?php echo e(get_option('gcal_id')); ?>'
                }
            ]
        });
        calendar.render();

    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/project-manager/Modules/Calendar/Providers/../Resources/views/appointments.blade.php ENDPATH**/ ?>