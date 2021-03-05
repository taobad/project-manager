<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('notification-count')->html();
} elseif ($_instance->childHasBeenRendered('Tv109bP')) {
    $componentId = $_instance->getRenderedChildComponentId('Tv109bP');
    $componentTag = $_instance->getRenderedChildComponentTagName('Tv109bP');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Tv109bP');
} else {
    $response = \Livewire\Livewire::mount('notification-count');
    $html = $response->html();
    $_instance->logRenderedChild('Tv109bP', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?><?php /**PATH /var/www/project-manager/resources/views/partial/notifications.blade.php ENDPATH**/ ?>