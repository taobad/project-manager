<?php $__env->startSection('content'); ?>
<section id="content" class="bg-indigo-100">
  <section class="vbox">
    <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
      <div class="flex justify-between text-gray-500">
        <div>
          <div class="btn-group">
            <button class="<?php echo e(themeButton()); ?> dropdown-toggle" data-toggle="dropdown">
              <?php echo trans('app.'.'filter'); ?>
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li>
                <a href="<?php echo e(route('tasks.index', ['filter' => 'backlog'])); ?>">
                  <?php echo trans('app.'.'backlog'); ?>
                </a>
              </li>
              <li>
                <a href="<?php echo e(route('tasks.index', ['filter' => 'ongoing'])); ?>"><?php echo trans('app.'.'ongoing'); ?></a>
              </li>
              <li><a href="<?php echo e(route('tasks.index', ['filter' => 'done'])); ?>"><?php echo trans('app.'.'done'); ?></a></li>
              <li>
                <a href="<?php echo e(route('tasks.index', ['filter' => 'overdue'])); ?>"><?php echo trans('app.'.'overdue'); ?></a>
              </li>
              <li>
                <a href="<?php echo e(route('tasks.index', ['filter' => 'mine'])); ?>"><?php echo trans('app.'.'mine'); ?></a>
              </li>
              <li><a href="<?php echo e(route('tasks.index')); ?>"><?php echo trans('app.'.'all'); ?> </a></li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <section class="scrollable wrapper" id="task-list">

      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('task.index-table')->html();
} elseif ($_instance->childHasBeenRendered('FyRVP59')) {
    $componentId = $_instance->getRenderedChildComponentId('FyRVP59');
    $componentTag = $_instance->getRenderedChildComponentTagName('FyRVP59');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('FyRVP59');
} else {
    $response = \Livewire\Livewire::mount('task.index-table');
    $html = $response->html();
    $_instance->logRenderedChild('FyRVP59', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

    </section>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/project-manager/Modules/Tasks/Providers/../Resources/views/index.blade.php ENDPATH**/ ?>