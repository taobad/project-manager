<script type="text/javascript">
    $(document).ready(function () {
        var calendarEl = document.getElementById('calendar');
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
                        <?php $__currentLoopData = Auth::user()->schedules->where('calendar_id', activeCalendar()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        {
                            title: '<?php echo e(addslashes($event->event_name)); ?>',
                            start: '<?php echo e(date('Y-m-d H:i:s', strtotime($event->start_date))); ?>',
                            end: '<?php echo e(date('Y-m-d H:i:s', strtotime($event->end_date))); ?>',
                            url: '<?php echo e($event->url); ?>',
                            description: '<?php echo e($event->description); ?>',
                            type: 'fo',
                            allDay: false,
                            color: '<?php echo e($event->color); ?>'
                        },
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!isAdmin() && Auth::user()->profile->company > 0): ?>
                        <?php $__currentLoopData = Auth::user()->profile->business->invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        {
                            title: '<?php echo e(addslashes($inv->name)); ?>',
                            start: '<?php echo e(date('Y-m-d H:i:s', strtotime($inv->due_date))); ?>',
                            end: '<?php echo e(date('Y-m-d H:i:s', strtotime($inv->due_date))); ?>',
                            url: '<?php echo e(route('invoices.view', $inv->id)); ?>',
                            description: '<?php echo e($inv->reference_no); ?> due',
                            type: 'fo',
                            allDay: false,
                            color: '#545caf'
                        },
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = Auth::user()->profile->business->estimates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        {
                            title: '<?php echo e(addslashes($est->name)); ?>',
                            start: '<?php echo e(date('Y-m-d H:i:s', strtotime($est->due_date))); ?>',
                            end: '<?php echo e(date('Y-m-d H:i:s', strtotime($est->due_date))); ?>',
                            url: '<?php echo e(route('estimates.view', $est->id)); ?>',
                            description: '<?php echo e($est->reference_no); ?> due',
                            type: 'fo',
                            allDay: false,
                            color: '#4a68f8'
                        },
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = Auth::user()->profile->business->contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        {
                            title: '<?php echo e(addslashes($contract->contract_title)); ?>',
                            start: '<?php echo e(date('Y-m-d H:i:s', strtotime($contract->expiry_date))); ?>',
                            end: '<?php echo e(date('Y-m-d H:i:s', strtotime($contract->expiry_date))); ?>',
                            url: '<?php echo e(route('contracts.view', $contract->id)); ?>',
                            description: '<?php echo e($contract->company->name); ?> contract',
                            type: 'fo',
                            allDay: false,
                            color: '#00d65f'
                        },
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = Auth::user()->profile->business->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        {
                            title: '<?php echo e(addslashes($payment->code)); ?>',
                            start: '<?php echo e(date('Y-m-d H:i:s', strtotime($payment->payment_date))); ?>',
                            end: '<?php echo e(date('Y-m-d H:i:s', strtotime($payment->payment_date))); ?>',
                            url: '<?php echo e(route('invoices.view', $payment->invoice_id)); ?>',
                            description: '<?php echo e($payment->amount_formatted); ?> received',
                            type: 'fo',
                            allDay: false,
                            color: '#f43445'
                        },
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = Auth::user()->profile->business->projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        {
                            title: '<?php echo e(addslashes($project->name)); ?>',
                            start: '<?php echo e(date('Y-m-d H:i:s', strtotime($project->due_date))); ?>',
                            end: '<?php echo e(date('Y-m-d H:i:s', strtotime($project->due_date))); ?>',
                            url: '<?php echo e(route('projects.view', $project->id)); ?>',
                            description: '<?php echo e(str_limit($project->description,25)); ?>',
                            type: 'fo',
                            allDay: false,
                            color: '#0772d1'
                        },
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endif; ?>
                    ],
                    color: '#38354a',
                    textColor: 'white'
                },
                {
                    googleCalendarId: '<?php echo e(get_option('gcal_id')); ?>',
                    color: '#1a73e8',
                }
            ]
        });
        calendar.render();
    });
</script><?php /**PATH /var/www/project-manager/Modules/Calendar/Providers/../Resources/views/main_calendar.blade.php ENDPATH**/ ?>