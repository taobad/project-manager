<?php echo $__env->make('partial.base_currency', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('payment.stats')->html();
} elseif ($_instance->childHasBeenRendered('DEJUZXk')) {
    $componentId = $_instance->getRenderedChildComponentId('DEJUZXk');
    $componentTag = $_instance->getRenderedChildComponentTagName('DEJUZXk');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('DEJUZXk');
} else {
    $response = \Livewire\Livewire::mount('payment.stats');
    $html = $response->html();
    $_instance->logRenderedChild('DEJUZXk', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('payment.payment-chart')->html();
} elseif ($_instance->childHasBeenRendered('FU1EXFw')) {
    $componentId = $_instance->getRenderedChildComponentId('FU1EXFw');
    $componentTag = $_instance->getRenderedChildComponentTagName('FU1EXFw');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('FU1EXFw');
} else {
    $response = \Livewire\Livewire::mount('payment.payment-chart');
    $html = $response->html();
    $_instance->logRenderedChild('FU1EXFw', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?><?php /**PATH /var/www/project-manager/Modules/Dashboard/Providers/../Resources/views/_includes/payments.blade.php ENDPATH**/ ?>