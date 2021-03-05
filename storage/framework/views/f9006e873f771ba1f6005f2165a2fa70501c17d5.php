<ul class="list-feed text-xs">
    <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="border-<?php echo e(get_option('theme_color')); ?>">
        <div class="text-gray-600">
            <strong><?php echo e(optional($activity->user)->name); ?></strong>
            <a href="<?php echo e($activity->url); ?>"
                class="pull-right text-indigo-600"><?php echo e(dateElapsed($activity->created_at)); ?></a>

        </div>
        <span class="text-gray-700"><?php echo trans('activity.'.$activity->action, ['value1' => '<span
                class="font-thin text-gray-600">'.$activity->value1.'</span>', 'value2' => '<span
                class="font-thin text-gray-600">'.$activity->value2.'</span>']); ?>
        </span>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</ul><?php /**PATH /var/www/project-manager/resources/views/widgets/activities/dashboard.blade.php ENDPATH**/ ?>