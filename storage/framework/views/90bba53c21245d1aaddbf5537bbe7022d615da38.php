<section class="panel panel-default">
  <header class="px-2 py-3 font-bold bg-gray-200 border-b">
    <?php echo e($year); ?> - <?php echo trans('app.'.'yearly_overview'); ?>
    <div class="m-b-sm pull-right">
      <div class="btn-group">
        <button class="<?php echo e(themeButton()); ?> dropdown-toggle" data-toggle="dropdown"><?php echo trans('app.'.'year'); ?> <span class="caret"></span></button>
        <ul class="dropdown-menu">
          <?php $min = date('Y') - 3; ?>
          <?php $__currentLoopData = range($min, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><a href="?m=expenses&setyear=<?php echo e($y); ?>"><?php echo e($y); ?></a></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>

  </header>
  <div class="panel-body">
    <div id="billable-chart"></div>
  </div>
</section>

<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
  let chart = new frappe.Chart( "#billable-chart", {
  data: {
  labels: ["<?php echo e(langdate('cal_jan')); ?>", "<?php echo e(langdate('cal_feb')); ?>", "<?php echo e(langdate('cal_mar')); ?>", "<?php echo e(langdate('cal_apr')); ?>", "<?php echo e(langdate('cal_may')); ?>", "<?php echo e(langdate('cal_jun')); ?>",
  "<?php echo e(langdate('cal_jul')); ?>", "<?php echo e(langdate('cal_aug')); ?>", "<?php echo e(langdate('cal_sep')); ?>", "<?php echo e(langdate('cal_oct')); ?>", "<?php echo e(langdate('cal_nov')); ?>", "<?php echo e(langdate('cal_dec')); ?>"],
  datasets: [
  {
    name: "<?php echo e(langapp('billable')); ?>", chartType: 'line',
    values: [<?php echo e($billable['jan']); ?>, <?php echo e($billable['feb']); ?>, <?php echo e($billable['mar']); ?>, <?php echo e($billable['apr']); ?>, <?php echo e($billable['may']); ?>, <?php echo e($billable['jun']); ?>, <?php echo e($billable['jul']); ?>,
    <?php echo e($billable['aug']); ?>, <?php echo e($billable['sep']); ?>, <?php echo e($billable['oct']); ?>, <?php echo e($billable['nov']); ?>, <?php echo e($billable['dec']); ?>]
  },
  {
    name: "<?php echo e(langapp('billed')); ?>", chartType: 'line',
    values: [<?php echo e($billed['jan']); ?>, <?php echo e($billed['feb']); ?>, <?php echo e($billed['mar']); ?>, <?php echo e($billed['apr']); ?>, <?php echo e($billed['may']); ?>, <?php echo e($billed['jun']); ?>, <?php echo e($billed['jul']); ?>,
    <?php echo e($billed['aug']); ?>, <?php echo e($billed['sep']); ?>, <?php echo e($billed['oct']); ?>, <?php echo e($billed['nov']); ?>, <?php echo e($billed['dec']); ?>]
  }
  ],
  
  },
  title: "<?php echo e(langapp('expenses')); ?> - <?php echo e(get_option('default_currency')); ?>",
  type: 'axis-mixed',
  height: 300,
  colors: ['#F6AD55', '#5A67D8'],
  tooltipOptions: {
    formatTooltipX: d => (d + '').toUpperCase(),
    formatTooltipY: function formatTooltipY(d) {
        return d.format(2, 3, "<?php echo e(get_option('thousands_separator')); ?>", "<?php echo e(get_option('decimal_separator')); ?>") + "<?php echo e(get_option('default_currency_symbol')); ?>";
      }
  }
  });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /var/www/project-manager/resources/views/livewire/expense/chart.blade.php ENDPATH**/ ?>