<div class="row">

    <div class="col-sm-4">
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700"><?php echo trans('app.'.'won_deals'); ?> </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        <?php echo metrics('deals_won'); ?>
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700"><?php echo trans('app.'.'lost'); ?> </span>
                    <span class="block pull-right m-l text-red-600 font-semibold">
                        <?php echo metrics('deals_lost'); ?>

                    </span>
                </div>
            </div>
        </section>


        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700"><?php echo trans('app.'.'this_month'); ?> </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">

                        <?php echo metrics('deals_this_month'); ?>

                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700"><?php echo trans('app.'.'last_month'); ?> </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        <?php echo metrics('deals_last_month'); ?>
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700"><?php echo trans('app.'.'sales_velocity'); ?> </span>
                    <span class="block text-primary pull-right m-l text-gray-700 font-semibold">
                        <?php echo e(getCalculated('sales-velocity')); ?>

                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700"><?php echo trans('app.'.'conversion_rate'); ?> </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        <?php echo e(round(getCalculated('conversion-rate'),2)); ?>%
                    </span>
                </div>
            </div>
        </section>









    </div>


    <div class="col-md-8 b-top">

        <?php echo app('arrilot.widget')->run('Deals\WonLostChart'); ?>

    </div>

</div>


<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title text-gray-600">1st <?php echo trans('app.'.'quarter'); ?> , <?php echo e($year); ?></h4>
            </header>
            <hr class="widget-separator">
            <div class="widget-body p-t-lg">
                <?php
                $janDeals = getCalculated('deals_1_'.$year);
                $febDeals = getCalculated('deals_2_'.$year);
                $marDeals = getCalculated('deals_3_'.$year);
                $semOne = array($janDeals, $febDeals, $marDeals);
                ?>
                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_january')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($janDeals); ?></div>
                </div>

                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_february')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($febDeals); ?>

                    </div>
                </div>

                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_march')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($marDeals); ?>

                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e(array_sum($semOne)); ?> <?php echo trans('app.'.'deals'); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="col-md-3 col-sm-6">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title text-gray-600">2nd <?php echo trans('app.'.'quarter'); ?> , <?php echo e($year); ?></h4>
            </header>

            <hr class="widget-separator">
            <div class="widget-body p-t-lg">
                <?php
                $aprDeals = getCalculated('deals_4_'.$year);
                $mayDeals = getCalculated('deals_5_'.$year);
                $junDeals = getCalculated('deals_6_'.$year);
                $semTwo = array($aprDeals, $mayDeals, $junDeals); ?>

                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_april')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($aprDeals); ?></div>
                </div>

                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_may')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($mayDeals); ?>

                    </div>
                </div>

                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_june')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($junDeals); ?>

                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e(array_sum($semTwo)); ?> <?php echo trans('app.'.'deals'); ?>
                    </div>
                </div>

            </div>

        </div>

    </div>



    <div class="col-md-3 col-sm-6">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title text-gray-600">3rd <?php echo trans('app.'.'quarter'); ?> , <?php echo e($year); ?></h4>
            </header>

            <hr class="widget-separator">
            <div class="widget-body p-t-lg">
                <?php
                $julDeals = getCalculated('deals_7_'.$year);
                $augDeals = getCalculated('deals_8_'.$year);
                $sepDeals = getCalculated('deals_9_'.$year);
                $semThree = array($julDeals, $augDeals, $sepDeals); ?>
                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_july')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($julDeals); ?></div>
                </div>

                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_august')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($augDeals); ?>

                    </div>
                </div>

                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_september')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($sepDeals); ?>

                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e(array_sum($semThree)); ?> <?php echo trans('app.'.'deals'); ?>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <div class="col-md-3 col-sm-6">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title text-gray-600">4th <?php echo trans('app.'.'quarter'); ?> , <?php echo e($year); ?></h4>
            </header>

            <hr class="widget-separator">
            <div class="widget-body p-t-lg">
                <?php
                $octDeals = getCalculated('deals_10_'.$year);
                $novDeals = getCalculated('deals_11_'.$year);
                $decDeals = getCalculated('deals_12_'.$year);
                $semFour = array($octDeals, $novDeals, $decDeals); ?>

                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_october')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($octDeals); ?></div>
                </div>

                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_november')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($novDeals); ?>

                    </div>
                </div>

                <div class="clearfix m-b-md span"><?php echo e(langdate('cal_december')); ?>

                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e($decDeals); ?>

                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        <?php echo e(array_sum($semFour)); ?> <?php echo trans('app.'.'deals'); ?>
                    </div>
                </div>

            </div>

        </div>

    </div>


</div><?php /**PATH /var/www/project-manager/Modules/Analytics/Providers/../Resources/views/_deals/dashboard.blade.php ENDPATH**/ ?>