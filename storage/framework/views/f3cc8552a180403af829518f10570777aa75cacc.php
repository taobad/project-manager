<?php if(!$alreadyConsentedWithCurrency): ?>
<div class="alert border-skye-blue-500 border" id="currency-alert">
    <button class="close" data-dismiss="alert" type="button">
        <span>×</span>
        <span class="sr-only">
            Close
        </span>
    </button>
    <?php echo trans('app.'.'amount_displayed_in_your_cur'); ?>
    <a class="text-skye-blue-500 font-bold" href="<?php echo e(route('settings.edit', ['section' => 'system'])); ?>">
        <?php echo e(get_option('default_currency')); ?>

    </a>
</div>

<?php $__env->startPush('pagescript'); ?>
<script>
    $('#currency-alert').on('closed.bs.alert', function() {
        setCookie("acceptCurrency", true, 365);
    });
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH /var/www/project-manager/resources/views/partial/base_currency.blade.php ENDPATH**/ ?>