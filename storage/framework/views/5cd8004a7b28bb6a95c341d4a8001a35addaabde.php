<aside class="b-l bg" id="">
    <ul class="text-xs text-gray-600 uppercase dashmenu no-border no-radius">
        <?php if (moduleActive('invoices')) { ?>
        <li class="<?php echo e($dashboard == 'invoices' ? themeText('font-semibold') : ''); ?>">
            <a href="<?php echo e(route('dashboard.index', ['dashboard' => 'invoices'])); ?>">
                <?php echo e(svg_image('solid/file-invoice-dollar')); ?> <?php echo trans('app.'.'invoicing'); ?>
            </a>
        </li>
        <?php } ?>
        <?php if (moduleActive('deals')) { ?>
        <li class="<?php echo e($dashboard == 'deals' ? themeText('font-semibold') : ''); ?>">
            <a href="<?php echo e(route('dashboard.index', ['dashboard' => 'deals'])); ?>">
                <?php echo e(svg_image('solid/chart-line')); ?> <?php echo trans('app.'.'sales'); ?>
            </a>
        </li>
        <?php } ?>
        <?php if (moduleActive('expenses')) { ?>
        <li class="<?php echo e($dashboard == 'expenses' ? themeText('font-semibold') : ''); ?>">
            <a href="<?php echo e(route('dashboard.index', ['dashboard' => 'expenses'])); ?>">
                <?php echo e(svg_image('solid/dollar-sign')); ?> <?php echo trans('app.'.'expenses'); ?>
            </a>
        </li>
        <?php } ?>
        <?php if (moduleActive('payments')) { ?>
        <li class="<?php echo e($dashboard == 'payments' ? themeText('font-semibold') : ''); ?>">
            <a href="<?php echo e(route('dashboard.index', ['dashboard' => 'payments'])); ?>">
                <?php echo e(svg_image('solid/credit-card')); ?> <?php echo trans('app.'.'payments'); ?>
            </a>
        </li>
        <?php } ?>
        <?php if (moduleActive('projects')) { ?>
        <li class="<?php echo e($dashboard == 'projects' ? themeText('font-semibold') : ''); ?>">
            <a href="<?php echo e(route('dashboard.index', ['dashboard' => 'projects'])); ?>">
                <?php echo e(svg_image('solid/project-diagram')); ?> <?php echo trans('app.'.'projects'); ?>
            </a>
        </li>
        <?php } ?>
        <?php if (moduleActive('tickets')) { ?>
        <li class="<?php echo e($dashboard == 'tickets' ? themeText('font-semibold') : ''); ?>">
            <a href="<?php echo e(route('dashboard.index', ['dashboard' => 'tickets'])); ?>">
                <?php echo e(svg_image('solid/life-ring')); ?> <?php echo trans('app.'.'ticketing'); ?>
            </a>
        </li>
        <?php } ?>
    </ul>
    <section class="scrollable">
        <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
            <section class="padder">
                <?php echo $__env->make('dashboard::_includes.'.$dashboard, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </section>
        </div>
    </section>
</aside>
<aside class="bg-white border aside-lg">
    <section class="vbox">
        <section class="scrollable" id="feeds">
            <div class="p-2 slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
                <?php echo $__env->make('dashboard::_sidebar.'.$dashboard, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </section>
    </section>
</aside><?php /**PATH /var/www/project-manager/Modules/Dashboard/Providers/../Resources/views/_users/admin.blade.php ENDPATH**/ ?>