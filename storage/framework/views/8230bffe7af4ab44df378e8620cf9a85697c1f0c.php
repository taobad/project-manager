<section class="panel panel-default">
  <header class="px-2 py-3 font-bold bg-gray-200 border-b">
    <?php echo e($year); ?> - <?php echo trans('app.'.'yearly_overview'); ?>
    <div class="m-b-sm pull-right">
      <div class="btn-group">
        <button class="btn <?php echo e(themeButton()); ?> dropdown-toggle" data-toggle="dropdown"><?php echo trans('app.'.'year'); ?> <span class="caret"></span></button>
        <ul class="dropdown-menu">
          <?php $min = date('Y') - 3; ?>
          <?php $__currentLoopData = range($min, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><a href="?setyear=<?php echo e($y); ?>"><?php echo e($y); ?></a></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>
  </header>

  <div class="panel-body">

    <div id="receipts-chart"></div>
  </div>

</section>


<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
  let chart = new frappe.Chart( "#receipts-chart", {
  data: {
  labels: ["<?php echo e(langdate('cal_jan')); ?>", "<?php echo e(langdate('cal_feb')); ?>", "<?php echo e(langdate('cal_mar')); ?>", "<?php echo e(langdate('cal_apr')); ?>", "<?php echo e(langdate('cal_may')); ?>", "<?php echo e(langdate('cal_jun')); ?>",
  "<?php echo e(langdate('cal_jul')); ?>", "<?php echo e(langdate('cal_aug')); ?>", "<?php echo e(langdate('cal_sep')); ?>", "<?php echo e(langdate('cal_oct')); ?>", "<?php echo e(langdate('cal_nov')); ?>", "<?php echo e(langdate('cal_dec')); ?>"],
  datasets: [
  {
    name: "<?php echo e(langapp('payments')); ?>", chartType: 'bar',
    values: [<?php echo e($payments['jan']); ?>, <?php echo e($payments['feb']); ?>, <?php echo e($payments['mar']); ?>, <?php echo e($payments['apr']); ?>, <?php echo e($payments['may']); ?>, <?php echo e($payments['jun']); ?>, <?php echo e($payments['jul']); ?>,
    <?php echo e($payments['aug']); ?>, <?php echo e($payments['sep']); ?>, <?php echo e($payments['oct']); ?>, <?php echo e($payments['nov']); ?>, <?php echo e($payments['dec']); ?>]
  },
  {
    name: "<?php echo e(langapp('credits')); ?>", chartType: 'line',
    values: [<?php echo e($credits['jan']); ?>, <?php echo e($credits['feb']); ?>, <?php echo e($credits['mar']); ?>, <?php echo e($credits['apr']); ?>, <?php echo e($credits['may']); ?>, <?php echo e($credits['jun']); ?>, <?php echo e($credits['jul']); ?>,
    <?php echo e($credits['aug']); ?>, <?php echo e($credits['sep']); ?>, <?php echo e($credits['oct']); ?>, <?php echo e($credits['nov']); ?>, <?php echo e($credits['dec']); ?>]
  }
  ],
  
  },
  title: "<?php echo e(langapp('receipts')); ?> - <?php echo e(langapp('credits')); ?>",
  type: 'axis-mixed',
  height: 300,
  colors: ['#68D391', '#7F9CF5'],
  tooltipOptions: {
    formatTooltipX: d => (d + '').toUpperCase(),
    formatTooltipY: function formatTooltipY(d) {
        return d.format(2, 3, "<?php echo e(get_option('thousands_separator')); ?>", "<?php echo e(get_option('decimal_separator')); ?>") + "<?php echo e(get_option('default_currency_symbol')); ?>";
      }
  }
  });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /var/www/project-manager/resources/views/livewire/payment/payment-chart.blade.php ENDPATH**/ ?>