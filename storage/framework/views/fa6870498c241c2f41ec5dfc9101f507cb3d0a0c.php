<?php echo $__env->make('partial.base_currency', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('expense.stats')->html();
} elseif ($_instance->childHasBeenRendered('9uXUi7O')) {
    $componentId = $_instance->getRenderedChildComponentId('9uXUi7O');
    $componentTag = $_instance->getRenderedChildComponentTagName('9uXUi7O');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('9uXUi7O');
} else {
    $response = \Livewire\Livewire::mount('expense.stats');
    $html = $response->html();
    $_instance->logRenderedChild('9uXUi7O', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('expense.chart')->html();
} elseif ($_instance->childHasBeenRendered('eBxjIE7')) {
    $componentId = $_instance->getRenderedChildComponentId('eBxjIE7');
    $componentTag = $_instance->getRenderedChildComponentTagName('eBxjIE7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('eBxjIE7');
} else {
    $response = \Livewire\Livewire::mount('expense.chart');
    $html = $response->html();
    $_instance->logRenderedChild('eBxjIE7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?><?php /**PATH /var/www/project-manager/Modules/Dashboard/Providers/../Resources/views/_includes/expenses.blade.php ENDPATH**/ ?>