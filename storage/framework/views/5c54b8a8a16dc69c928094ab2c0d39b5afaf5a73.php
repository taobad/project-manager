<?php if(strlen(config('system.g_analytics_tracking_id'))): ?>
<!-- Global site tag (gtag.js) - Google Analytics TODO Remove on production -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(config('system.g_analytics_tracking_id')); ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', '<?php echo e(config('system.g_analytics_tracking_id')); ?>');
</script>
<?php endif; ?><?php /**PATH /var/www/project-manager/resources/views/partial/g-analytics.blade.php ENDPATH**/ ?>