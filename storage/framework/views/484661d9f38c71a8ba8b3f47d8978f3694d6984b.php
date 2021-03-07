<div class="">

    <div class="grid grid-cols-1 mt-5 overflow-hidden bg-white rounded-lg shadow md:grid-cols-3">
        <div>
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="<?php echo trans('app.'.'open'); ?>">
                        <?php echo trans('app.'.'open'); ?>
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline <?php echo e(themeText('text-2xl font-semibold leading-8')); ?>">
                            <?php echo e(getCalculated('tickets_open')); ?>

                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                <?php echo trans('app.'.'tickets'); ?>
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-orange-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="<?php echo trans('app.'.'closed'); ?>">
                        <?php echo trans('app.'.'closed'); ?>
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline <?php echo e(themeText('text-2xl font-semibold leading-8')); ?>">
                            <?php echo e(getCalculated('tickets_closed')); ?>

                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                <?php echo trans('app.'.'tickets'); ?>
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-green-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-check-circle"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip"
                        title="<?php echo e(dateFormatted(now()->startOfWeek())); ?> - <?php echo e(dateFormatted(now()->endOfWeek())); ?>">
                        <?php echo trans('app.'.'this_week'); ?>
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1  md:block lg:flex">
                        <div class="flex items-baseline <?php echo e(themeText('text-2xl font-semibold leading-8')); ?>">
                            <?php echo e(getCalculated('tickets_this_week')); ?>

                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                <?php echo trans('app.'.'tickets'); ?>
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-green-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-calendar-check"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>



<div class="flex m-2 justify-evenly">
    <div class="px-3 py-2 border border-transparent text-sm leading-4 rounded-full text-white <?php echo e(themeBg()); ?> hover:bg-indigo-600 focus:outline-none focus:border-indigo-700">
        <a href="/analytics?m=tickets" class="hover:text-white"> <i class="mr-2 fas fa-chart-line"></i> View complete
            Report </a>
    </div>

</div><?php /**PATH /var/www/project-manager/resources/views/livewire/ticket/stats.blade.php ENDPATH**/ ?>