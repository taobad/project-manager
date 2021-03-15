<?php $__env->startSection('content'); ?>
<section id="content" class="bg-indigo-100">
  <section class="vbox">
    <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
      <div class="flex justify-between text-gray-500">
        <div>
          <span class="text-xl font-semibold text-gray-600"><?php echo trans('app.'.'contacts'); ?></span>
        </div>
        <div>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_create')): ?>
          <a href="<?php echo e(route('contacts.create')); ?>" class="btn <?php echo e(themeButton()); ?>" data-toggle="ajaxModal">
            <?php echo e(svg_image('solid/plus')); ?> <?php echo trans('app.'.'create'); ?>
          </a>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contacts_create')): ?>
          <div class="btn-group">
            <button class="btn <?php echo e(themeButton()); ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <?php echo trans('app.'.'import'); ?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="<?php echo e(route('contacts.import', ['type' => 'contacts'])); ?>" data-toggle="ajaxModal"><?php echo trans('app.'.'csv_file'); ?></a></li>
              <li><a href="<?php echo e(route('contacts.import', ['type' => 'google'])); ?>">Google <?php echo trans('app.'.'contacts'); ?></a></li>
            </ul>
          </div>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contacts_view')): ?>
          <a href="<?php echo e(route('contacts.export')); ?>" class="btn <?php echo e(themeButton()); ?>">
            <?php echo e(svg_image('solid/download')); ?> CSV
          </a>
          <?php endif; ?>

          <div class="btn-group">
            <a href="<?php echo e(route('contacts.index', ['view' => 'table'])); ?>" data-toggle="tooltip" title="Table View" data-placement="bottom" class="btn <?php echo e(themeButton()); ?>">
              <?php echo e(svg_image('solid/bars')); ?>
            </a>
            <a href="<?php echo e(route('contacts.index', ['view' => 'grid'])); ?>" data-toggle="tooltip" title="Grid View" data-placement="bottom" class="btn <?php echo e(themeButton()); ?>">
              <?php echo e(svg_image('solid/columns')); ?>
            </a>
          </div>
        </div>
      </div>
    </header>
    <section class="scrollable wrapper scrollpane">

      <?php if($displayType == 'table'): ?>
      <?php echo $__env->make('contacts::table_view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if($displayType == 'grid'): ?>
      <?php echo Form::open(['route' => 'contacts.search', 'class' => '']); ?>

      <div class="input-group m-xs">

        <input type="text" class="input-sm form-control contact-search search" name="keyword" placeholder="Enter contact name">
        <span class="input-group-btn">
          <button class="btn <?php echo e(themeButton()); ?>" type="submit"><?php echo e(svg_image('solid/search')); ?> <?php echo trans('app.'.'search'); ?></button>
        </span>
      </div>
      <?php echo Form::close(); ?>

      <div id="ajaxData"></div>
      <?php endif; ?>


    </section>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<?php $__env->startPush('pagestyle'); ?>
<?php echo $__env->make('stacks.css.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('pagescript'); ?>
<?php if($displayType == 'grid'): ?>
<?php echo $__env->make('contacts::_scripts._ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php echo $__env->make('stacks.js.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/project-manager/Modules/Contacts/Providers/../Resources/views/index.blade.php ENDPATH**/ ?>