<?php $__env->startSection('content'); ?>
<section id="content" class="bg-indigo-100">
    <section class="vbox">
        <header class="bg-white header b-b b-light">
            <div class="btn-group pull-right">
                <a href="<?php echo e(route('leads.index', ['view' => 'table'])); ?>" data-toggle="tooltip" title="Table" data-placement="bottom" class="btn <?php echo e(themeButton()); ?>">
                    <?php echo e(svg_image('solid/bars')); ?>
                </a>
                <a href="<?php echo e(route('leads.index', ['view' => 'kanban'])); ?>" data-toggle="tooltip" title="Kanban" data-placement="bottom" class="btn <?php echo e(themeButton()); ?>">
                    <?php echo e(svg_image('solid/columns')); ?>
                </a>
                <a href="<?php echo e(route('leads.index', ['view' => 'heatmap'])); ?>" data-toggle="tooltip" title="Heatmap" data-placement="bottom" class="btn <?php echo e(themeButton()); ?>">
                    <?php echo e(svg_image('solid/chart-line')); ?>
                </a>
            </div>

            <div class="btn-group">
                <button class="btn <?php echo e(themeButton()); ?> dropdown-toggle" data-toggle="dropdown">
                    <?php echo trans('app.'.'filter'); ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?php echo e(route('leads.index', ['filter' => 'hot'])); ?>">
                            <?php echo trans('app.'.'hot'); ?> <?php echo trans('app.'.'leads'); ?> <?php echo e(svg_image('solid/fire','text-'.leadRatingClr('hot'))); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('leads.index', ['filter' => 'warm'])); ?>">
                            <?php echo trans('app.'.'warm'); ?> <?php echo trans('app.'.'leads'); ?> <?php echo e(svg_image('solid/fire','text-'.leadRatingClr('warm'))); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('leads.index', ['filter' => 'cold'])); ?>">
                            <?php echo trans('app.'.'cold'); ?> <?php echo trans('app.'.'leads'); ?> <?php echo e(svg_image('solid/fire', 'text-'.leadRatingClr('cold'))); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('leads.index', ['filter' => 'converted'])); ?>">
                            <?php echo trans('app.'.'converted'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('leads.index', ['filter' => 'archived'])); ?>">
                            <?php echo trans('app.'.'archived'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('leads.index')); ?>">
                            <?php echo trans('app.'.'all'); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <a href="<?php echo e(route('leads.create')); ?>" data-toggle="ajaxModal" data-rel="tooltip" title="<?php echo trans('app.'.'create'); ?>" class="btn <?php echo e(themeButton()); ?>">
                <?php echo e(svg_image('solid/plus')); ?> <?php echo trans('app.'.'create'); ?>
            </a>

            <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
            <a href="<?php echo e(route('settings.stages.show', 'leads')); ?>" data-toggle="ajaxModal" class="btn <?php echo e(themeButton()); ?> pull-right" data-rel="tooltip" title="<?php echo trans('app.'.'stages'); ?>"
                data-placement="bottom">
                <?php echo e(svg_image('solid/cogs')); ?>
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('leads_create')): ?>
            <div class="btn-group">
                <button class="btn <?php echo e(themeButton()); ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo trans('app.'.'import'); ?> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo e(route('leads.import', ['type' => 'leads'])); ?>" data-toggle="ajaxModal"><?php echo trans('app.'.'csv_file'); ?></a></li>
                    <li><a href="<?php echo e(route('leads.import', ['type' => 'google'])); ?>">Google <?php echo trans('app.'.'contacts'); ?></a></li>
                </ul>
            </div>

            <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
            <a href="<?php echo e(route('leads.export')); ?>" title="<?php echo trans('app.'.'export'); ?>  " class="btn <?php echo e(themeButton()); ?>">
                <?php echo e(svg_image('solid/file-csv')); ?> CSV
            </a>
            <?php endif; ?>

            <?php endif; ?>


        </header>
        <section class="overflow-x-auto scrollable wrapper">


            <div class="row">
                <?php if($displayType == 'table'): ?>
                <?php echo $__env->make('leads::table_view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if($displayType == 'kanban'): ?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body collapse in">
                            <div class="card-block">
                                <div class="">
                                    <div class="lobilists-wrapper lobilists single-line sortable ps-container ps-theme-dark ps-active-x">
                                        <?php
                                        $cards = App\Entities\Category::whereModule('leads')->orderBy('order',
                                        'asc')->get();
                                        ?>
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="lobilist-wrapper ps-container ps-theme-dark ps-active-y kanban-col">
                                            <div id="lobilist-list-0" class="bg-white lobilist lobilist-default rounded-t-md">
                                                <div class="bg-white lobilist-header ui-sortable-handle rounded-t-md">
                                                    <div class="text-gray-600 uppercase lobilist-title text-ellipsis">
                                                        <span class="border-l-0 arrow right"></span>
                                                        <?php echo e(ucfirst($card->name)); ?>

                                                    </div>
                                                </div>
                                                <div class="lobilist-body scrumboard slim-scroll" data-disable-fade-out="true" data-distance="0" data-size="3px" data-height="550"
                                                    data-color="#333333">
                                                    <ul class="lobilist-items ui-sortable list" id="<?php echo e(snake_case($card->name)); ?>">
                                                        <?php $leadCounter = 0; ?>
                                                        <?php $__currentLoopData = Modules\Leads\Entities\Lead::whereNull('archived_at')->where('stage_id',
                                                        $card->id)->with('agent')->orderByDesc('id')->take(50)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li id="<?php echo e($lead->id); ?>" draggable="true"
                                                            class="lobilist-item kanban-entry grab <?php echo e(!is_null($lead->unsubscribed_at) ? 'subscribe-bg' : ''); ?>">
                                                            <div class="ml-1 lobilist-item-title text-ellipsis">
                                                                <a href="<?php echo e(route('leads.view', ['lead' => $lead->id])); ?>" class="<?php echo e(themeText('font-semibold')); ?>">
                                                                    <?php echo e($lead->name); ?>

                                                                </a>
                                                                <?php if($lead->has_email): ?>
                                                                <?php echo e(svg_image('regular/envelope', 'text-success')); ?>
                                                                <?php endif; ?>

                                                                <?php if($lead->has_chats): ?>
                                                                <?php echo e(svg_image('brands/whatsapp', 'text-success')); ?>
                                                                <?php endif; ?>

                                                            </div>
                                                            <div class="text-gray-600 lobilist-item-description">
                                                                <small class="pull-right xs"> <?php echo e(svg_image('regular/user')); ?>
                                                                    <?php echo e(optional($lead->agent)->name); ?>

                                                                </small>

                                                                <span class="text-bold">
                                                                    <?php echo e($lead->computed_value); ?>

                                                                </span>
                                                            </div>
                                                            <small class="text-gray-600">
                                                                <?php echo e(!empty($lead->due_date) ? dateElapsed($lead->due_date) : ''); ?>

                                                                <?php echo e(svg_image('solid/fire','text-'.leadRatingClr($lead->rating_status))); ?>
                                                            </small>
                                                            <div class="lobilist-item-duedate">
                                                                <?php echo e(dateFormatted($lead->due_date)); ?>

                                                            </div>
                                                            <?php if($lead->sales_rep > 0): ?>
                                                            <span class="thumb-xs avatar lobilist-check">
                                                                <img src="<?php echo e($lead->agent->photo); ?>" class="img-circle">
                                                            </span>
                                                            <?php endif; ?>
                                                            <div class="todo-actions">
                                                                <?php if($lead->has_activity): ?>
                                                                <div class="edit-todo todo-action">
                                                                    <a href="<?php echo e(route('leads.view', ['lead' => $lead->id, 'tab' => 'activity'])); ?>">
                                                                        <?php echo e(svg_image('solid/tasks', 'text-warning')); ?>
                                                                    </a>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="drag-handler"></div>
                                                        </li>
                                                        <?php $leadCounter++; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                                <div class="lobilist-footer">
                                                    <div class="flex justify-between">
                                                        <div>
                                                            <?php if(isAdmin()): ?>
                                                            <span class="font-bold text-indigo-600"><?php echo metrics('leads_stage_'.$card->id); ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div>
                                                            <span class="text-gray-600 pull-right"><?php echo e($leadCounter); ?> <?php echo trans('app.'.'leads'); ?></span>
                                                        </div>
                                                    </div>


                                                    </span>


                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog processing-modal">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <?php echo e(svg_image('solid/sync-alt', 'fa-4x fa-spin')); ?>
                                                            <h4>Processing...</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if($displayType == 'heatmap'): ?>
                <?php echo $__env->make('leads::heatmap_view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>


        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<?php $__env->startPush('pagescript'); ?>
<script type="text/javascript">
    $(document).ready(function () {
var kanbanCol = $('.scrumboard');
draggableInit();
});
function draggableInit() {
var sourceId;
$('[draggable=true]').bind('dragstart', function (event) {
sourceId = $(this).parent().attr('id');
event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
});
$('.scrumboard').bind('dragover', function (event) {
event.preventDefault();
});
$('.scrumboard').bind('drop', function (event) {
var children = $(this).children();
var targetId = children.attr('id');
if (sourceId != targetId) {
var elementId = event.originalEvent.dataTransfer.getData("text/plain");
$('#processing-modal').modal('toggle');
setTimeout(function () {
var element = document.getElementById(elementId);
id = element.getAttribute('id');
axios.post('/api/v1/leads/'+id+'/movestage', {
id: id,
target: targetId
})
.then(function (response) {
toastr.success(response.data.message, '<?php echo trans('app.'.'success'); ?> ');
})
.catch(function (error) {
var errors = error.response.data.errors;
var errorsHtml= '';
$.each( errors, function( key, value ) {
errorsHtml += '<li>' + value[0] + '</li>';
});
toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
});
children.prepend(element);
$('#processing-modal').modal('toggle');
}, 1000);
}
event.preventDefault();
});
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/project-manager/Modules/Leads/Providers/../Resources/views/index.blade.php ENDPATH**/ ?>