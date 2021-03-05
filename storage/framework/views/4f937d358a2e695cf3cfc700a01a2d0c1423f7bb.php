<?php if($count): ?>
<li class="hidden-xs notif">
    <a href="#topAlerts" class="dropdown-toggle" data-toggle="class:show animated fadeInRight" wire:click="clearNotifications()">
        <?php echo e(svg_image('solid/bell')); ?>
        <span class="bg-indigo-500 badge badge-sm up m-l-n-sm display-inline" data-count="0">
            <span class="notif-count"><?php echo e($count); ?></span>
        </span>
    </a>
</li>
<?php endif; ?><?php /**PATH /var/www/project-manager/resources/views/livewire/notification-count.blade.php ENDPATH**/ ?>