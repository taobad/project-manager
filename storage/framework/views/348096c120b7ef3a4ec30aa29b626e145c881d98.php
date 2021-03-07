<section class="panel panel-default">
    <header class="panel-heading font-bold"><?php echo e($year); ?> - <?php echo trans('app.'.'yearly_overview'); ?> </header>
    <div class="panel-body">
        <div id="status-chart"></div>
    </div>
</section>


<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
    let status_chart = new frappe.Chart( "#status-chart", {
data: {
  labels: ["<?php echo e(langdate('cal_jan')); ?>", "<?php echo e(langdate('cal_feb')); ?>", "<?php echo e(langdate('cal_mar')); ?>", "<?php echo e(langdate('cal_apr')); ?>", "<?php echo e(langdate('cal_may')); ?>", "<?php echo e(langdate('cal_jun')); ?>", 
  "<?php echo e(langdate('cal_jul')); ?>", "<?php echo e(langdate('cal_aug')); ?>", "<?php echo e(langdate('cal_sep')); ?>", "<?php echo e(langdate('cal_oct')); ?>", "<?php echo e(langdate('cal_nov')); ?>", "<?php echo e(langdate('cal_dec')); ?>"],

  datasets: [
    {
      name: "<?php echo e(langapp('closed')); ?>", chartType: 'line',
      values: [<?php echo e($closed['jan']); ?>, <?php echo e($closed['feb']); ?>, <?php echo e($closed['mar']); ?>, <?php echo e($closed['apr']); ?>, <?php echo e($closed['may']); ?>, <?php echo e($closed['jun']); ?>, <?php echo e($closed['jul']); ?>,
       <?php echo e($closed['aug']); ?>, <?php echo e($closed['sep']); ?>, <?php echo e($closed['oct']); ?>, <?php echo e($closed['nov']); ?>, <?php echo e($closed['dec']); ?>]
    },
    {
      name: "<?php echo e(langapp('open')); ?>", chartType: 'line',
      values: [<?php echo e($open['jan']); ?>, <?php echo e($open['feb']); ?>, <?php echo e($open['mar']); ?>, <?php echo e($open['apr']); ?>, <?php echo e($open['may']); ?>, <?php echo e($open['jun']); ?>, <?php echo e($open['jul']); ?>,
       <?php echo e($open['aug']); ?>, <?php echo e($open['sep']); ?>, <?php echo e($open['oct']); ?>, <?php echo e($open['nov']); ?>, <?php echo e($open['dec']); ?>]
    }
  ],
},

title: "<?php echo e(langapp('tickets_analysis')); ?>",
type: 'axis-mixed',
height: 300,
colors: ['#667EEA', '#fdab29'],
tooltipOptions: {
  formatTooltipX: d => (d + '').toUpperCase(),
  formatTooltipY: d => d + '',
}
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH /var/www/project-manager/resources/views/livewire/ticket/yearly-chart.blade.php ENDPATH**/ ?>