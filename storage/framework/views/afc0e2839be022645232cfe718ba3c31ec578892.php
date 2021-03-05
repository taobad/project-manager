<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo e(svg_image('solid/envelope-open')); ?> <?php echo trans('app.'.'send_invite'); ?></h4>
        </div>


        <div class="modal-body">

        <?php echo Form::open(['route' => 'invite.process', 'class' => 'bs-example form-horizontal ajaxifyForm']); ?>

        

        <div class="form-group">
                <label class="col-lg-3 control-label"><?php echo trans('app.'.'email'); ?> <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="email" class="form-control" placeholder="johndoe@example.com" required name="email">
                </div>
        </div>




            <div class="modal-footer">

            <?php echo closeModalButton(); ?>

            <?php echo renderAjaxButton('send_invite'); ?>


            </div>
    <?php echo Form::close(); ?>




        </div>
</div>

<?php echo $__env->make('partial.ajaxify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/project-manager/resources/views/modal/invite.blade.php ENDPATH**/ ?>