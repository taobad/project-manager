<?php echo $__env->make('partial.base_currency', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('invoice.stats')->html();
} elseif ($_instance->childHasBeenRendered('NBww3jp')) {
    $componentId = $_instance->getRenderedChildComponentId('NBww3jp');
    $componentTag = $_instance->getRenderedChildComponentTagName('NBww3jp');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('NBww3jp');
} else {
    $response = \Livewire\Livewire::mount('invoice.stats');
    $html = $response->html();
    $_instance->logRenderedChild('NBww3jp', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('invoice.chart')->html();
} elseif ($_instance->childHasBeenRendered('HvKLDkf')) {
    $componentId = $_instance->getRenderedChildComponentId('HvKLDkf');
    $componentTag = $_instance->getRenderedChildComponentTagName('HvKLDkf');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('HvKLDkf');
} else {
    $response = \Livewire\Livewire::mount('invoice.chart');
    $html = $response->html();
    $_instance->logRenderedChild('HvKLDkf', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?><?php /**PATH /var/www/project-manager/Modules/Dashboard/Providers/../Resources/views/_includes/invoices.blade.php ENDPATH**/ ?>