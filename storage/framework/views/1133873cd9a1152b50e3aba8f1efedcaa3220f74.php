<aside class="bg-light lter b-l aside-md hide animated fadeInRight scrollable notifier" id="topAlerts">
    <header class="bg-white border-b header">
        <a class="pull-right btn <?php echo e(themeButton()); ?>" id="clear-alerts" data-placement="left" data-toggle="tooltip" title="Clear All">
            <?php echo e(svg_image('solid/backspace')); ?>
        </a>
        <p><?php echo trans('app.'.'notifications'); ?></p>
    </header>
    <div class="slim-scroll" data-disable-fade-out="true" data-distance="0" data-height="500" data-size="5px">
        <?php if($notifications->count()): ?>
        <div class="m-1">
            <div class="list-group list-group-alt animated fadeInRight notifier-list">
                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="list-group-item">
                    <span class="text-sm font-thin" data-toggle="tooltip" title="<?php echo e($notification->created_at->diffForHumans()); ?>" data-placement="bottom">
                        <i class="fas fa-<?php echo e($notification->data['icon']); ?> text-indigo-500" wire:click="markAsRead('<?php echo e($notification->id); ?>')"></i>
                        <?php echo e($notification->data['subject']); ?>

                    </span>
                    <span class="text-xs text-gray-600 media-body">
                        <?php echo parsedown($notification->data['activity']); ?>
                    </span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php else: ?>
        <div class="p-2">
            <p class="text-sm text-gray-600">
                You have no unread notifications
            </p>
        </div>
        <?php endif; ?>
    </div>
</aside><?php /**PATH /var/www/project-manager/resources/views/livewire/notifications.blade.php ENDPATH**/ ?>