<?php if($sortField !== $field): ?>
    <i class="text-muted fas fa-sort"></i>
<?php elseif($sortAsc): ?>
    <i class="fas fa-sort-up"></i>
<?php else: ?>
    <i class="fas fa-sort-down"></i>
<?php endif; ?>
<?php /**PATH /var/www/project-manager/resources/views/partial/_sort-icon.blade.php ENDPATH**/ ?>