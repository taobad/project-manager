<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('ticket.stats')->html();
} elseif ($_instance->childHasBeenRendered('l31VfLc')) {
    $componentId = $_instance->getRenderedChildComponentId('l31VfLc');
    $componentTag = $_instance->getRenderedChildComponentTagName('l31VfLc');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l31VfLc');
} else {
    $response = \Livewire\Livewire::mount('ticket.stats');
    $html = $response->html();
    $_instance->logRenderedChild('l31VfLc', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('ticket.reply-chart')->html();
} elseif ($_instance->childHasBeenRendered('yofrA0k')) {
    $componentId = $_instance->getRenderedChildComponentId('yofrA0k');
    $componentTag = $_instance->getRenderedChildComponentTagName('yofrA0k');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('yofrA0k');
} else {
    $response = \Livewire\Livewire::mount('ticket.reply-chart');
    $html = $response->html();
    $_instance->logRenderedChild('yofrA0k', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('ticket.yearly-chart')->html();
} elseif ($_instance->childHasBeenRendered('cHhW4l5')) {
    $componentId = $_instance->getRenderedChildComponentId('cHhW4l5');
    $componentTag = $_instance->getRenderedChildComponentTagName('cHhW4l5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('cHhW4l5');
} else {
    $response = \Livewire\Livewire::mount('ticket.yearly-chart');
    $html = $response->html();
    $_instance->logRenderedChild('cHhW4l5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?><?php /**PATH /var/www/project-manager/Modules/Dashboard/Providers/../Resources/views/_includes/tickets.blade.php ENDPATH**/ ?>