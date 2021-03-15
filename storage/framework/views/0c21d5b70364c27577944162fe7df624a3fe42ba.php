<div class="">

    <div class="grid grid-cols-1 mt-5 overflow-hidden bg-white rounded-lg shadow md:grid-cols-3">
        <div>
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="<?php echo trans('app.'.'this_month'); ?>">
                        <?php echo trans('app.'.'this_month'); ?>
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline <?php echo e(themeText('text-2xl font-semibold leading-8')); ?>">
                            <?php echo metrics('deals_this_month'); ?>
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                <?php echo e(get_option('default_currency')); ?>

                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-orange-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-file-invoice"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="<?php echo trans('app.'.'paid'); ?>">
                        <?php echo trans('app.'.'won_deals'); ?>
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline <?php echo e(themeText('text-2xl font-semibold leading-8')); ?>">
                            <?php echo metrics('deals_won'); ?>
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                <?php echo e(get_option('default_currency')); ?>

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
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="<?php echo trans('app.'.'forecasted'); ?>">
                        <?php echo trans('app.'.'forecasted'); ?>
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline <?php echo e(themeText('text-2xl font-semibold leading-8')); ?>">
                            <?php echo metrics('deals_forecast'); ?>
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                <?php echo e(get_option('default_currency')); ?>

                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-red-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-chart-line"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>



<div class="flex m-2 justify-evenly">
    <div class="px-3 py-2 text-sm leading-4 text-white <?php echo e(themeBg()); ?> border border-transparent rounded-full  hover:bg-indigo-600 focus:outline-none focus:border-indigo-700">
        <a href="/analytics?m=deals" class="hover:text-white"> <i class="mr-2 fas fa-chart-line"></i> View complete
            Report </a>
    </div>

</div><?php /**PATH /var/www/project-manager/resources/views/livewire/deal/stats.blade.php ENDPATH**/ ?>