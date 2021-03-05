<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('notifications')->html();
} elseif ($_instance->childHasBeenRendered('RwTKnju')) {
    $componentId = $_instance->getRenderedChildComponentId('RwTKnju');
    $componentTag = $_instance->getRenderedChildComponentTagName('RwTKnju');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('RwTKnju');
} else {
    $response = \Livewire\Livewire::mount('notifications');
    $html = $response->html();
    $_instance->logRenderedChild('RwTKnju', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?><?php /**PATH /var/www/project-manager/resources/views/partial/notifier.blade.php ENDPATH**/ ?>