<?php echo $__env->make('partial.base_currency', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('deal.stats')->html();
} elseif ($_instance->childHasBeenRendered('M5rhuKB')) {
    $componentId = $_instance->getRenderedChildComponentId('M5rhuKB');
    $componentTag = $_instance->getRenderedChildComponentTagName('M5rhuKB');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('M5rhuKB');
} else {
    $response = \Livewire\Livewire::mount('deal.stats');
    $html = $response->html();
    $_instance->logRenderedChild('M5rhuKB', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('deal.won-chart')->html();
} elseif ($_instance->childHasBeenRendered('y88umJg')) {
    $componentId = $_instance->getRenderedChildComponentId('y88umJg');
    $componentTag = $_instance->getRenderedChildComponentTagName('y88umJg');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('y88umJg');
} else {
    $response = \Livewire\Livewire::mount('deal.won-chart');
    $html = $response->html();
    $_instance->logRenderedChild('y88umJg', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('deal.stages-chart')->html();
} elseif ($_instance->childHasBeenRendered('XBruRVv')) {
    $componentId = $_instance->getRenderedChildComponentId('XBruRVv');
    $componentTag = $_instance->getRenderedChildComponentTagName('XBruRVv');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('XBruRVv');
} else {
    $response = \Livewire\Livewire::mount('deal.stages-chart');
    $html = $response->html();
    $_instance->logRenderedChild('XBruRVv', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?><?php /**PATH /var/www/project-manager/Modules/Dashboard/Providers/../Resources/views/_includes/deals.blade.php ENDPATH**/ ?>