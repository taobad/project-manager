<section class="panel panel-default">
  <header class="px-2 py-3 font-bold bg-gray-200 border-b">
    <?php echo e($year); ?> - <?php echo trans('app.'.'yearly_overview'); ?>
    <div class="mb-1 pull-right">
      <div class="btn-group">
        <button class="<?php echo e(themeButton()); ?> dropdown-toggle" data-toggle="dropdown"><?php echo trans('app.'.'year'); ?> <span class="caret"></span></button>
        <ul class="dropdown-menu">
          <?php $min = date('Y') - 3; ?>
          <?php $__currentLoopData = range($min, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li>
            <a href="?setyear=<?php echo e($y); ?>"><?php echo e($y); ?></a>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>
  </header>
  <div class="panel-body">
    <div id="replies-chart"></div>
  </div>
</section>



<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
  let chart = new frappe.Chart( "#replies-chart", {
    data: {
      labels: ["<?php echo e(langdate('cal_jan')); ?>", "<?php echo e(langdate('cal_feb')); ?>", "<?php echo e(langdate('cal_mar')); ?>", "<?php echo e(langdate('cal_apr')); ?>", "<?php echo e(langdate('cal_may')); ?>", "<?php echo e(langdate('cal_jun')); ?>", 
      "<?php echo e(langdate('cal_jul')); ?>", "<?php echo e(langdate('cal_aug')); ?>", "<?php echo e(langdate('cal_sep')); ?>", "<?php echo e(langdate('cal_oct')); ?>", "<?php echo e(langdate('cal_nov')); ?>", "<?php echo e(langdate('cal_dec')); ?>"],

      datasets: [
        {
          name: "<?php echo e(langapp('tickets')); ?>", chartType: 'bar',
          values: [<?php echo e($tickets['jan']); ?>, <?php echo e($tickets['feb']); ?>, <?php echo e($tickets['mar']); ?>, <?php echo e($tickets['apr']); ?>, <?php echo e($tickets['may']); ?>, <?php echo e($tickets['jun']); ?>, <?php echo e($tickets['jul']); ?>,
           <?php echo e($tickets['aug']); ?>, <?php echo e($tickets['sep']); ?>, <?php echo e($tickets['oct']); ?>, <?php echo e($tickets['nov']); ?>, <?php echo e($tickets['dec']); ?>]
        },
        {
          name: "<?php echo e(langapp('replies')); ?>", chartType: 'line',
          values: [<?php echo e($replies['jan']); ?>, <?php echo e($replies['feb']); ?>, <?php echo e($replies['mar']); ?>, <?php echo e($replies['apr']); ?>, <?php echo e($replies['may']); ?>, <?php echo e($replies['jun']); ?>, <?php echo e($replies['jul']); ?>,
           <?php echo e($replies['aug']); ?>, <?php echo e($replies['sep']); ?>, <?php echo e($replies['oct']); ?>, <?php echo e($replies['nov']); ?>, <?php echo e($replies['dec']); ?>]
        }
      ],

      
    },

    title: "<?php echo e(langapp('tickets_and_conversations')); ?>",
    type: 'axis-mixed',
    height: 300,
    colors: ['#667EEA', '#d2e186'],

    tooltipOptions: {
      formatTooltipX: d => (d + '').toUpperCase(),
      formatTooltipY: d => d + '',
    }
  });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /var/www/project-manager/resources/views/livewire/ticket/reply-chart.blade.php ENDPATH**/ ?>