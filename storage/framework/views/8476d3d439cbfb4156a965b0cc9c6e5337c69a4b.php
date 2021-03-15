<div class="col-lg-12">

    <section class="panel panel-default">

        <form id="frm-deal" method="POST">
            <input type="hidden" name="module" value="deals">

            <div class="table-responsive">
                <table id="deals-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="hide"></th>
                            <th class="no-sort">
                                <label>
                                    <input name="select_all" value="1" id="select-all" type="checkbox" />
                                    <span class="label-text"></span>
                                </label>
                            </th>
                            <th><?php echo trans('app.'.'title'); ?> </th>
                            <th class="col-currency"><?php echo trans('app.'.'deal_value'); ?> </th>
                            <th><?php echo trans('app.'.'stage'); ?></th>
                            <th><?php echo trans('app.'.'company_name'); ?></th>
                            <th class="hidden-sm"><?php echo trans('app.'.'contact_person'); ?> </th>
                            <th class="col-date"><?php echo trans('app.'.'close_date'); ?> </th>
                        </tr>
                    </thead>

                </table>

            </div>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('deals_update')): ?>
            <button type="submit" id="button" class="btn <?php echo e(themeButton()); ?> m-xs" value="bulk-archive">
                <span class=""><?php echo e(svg_image('solid/archive')); ?> <?php echo trans('app.'.'archive'); ?></span>
            </button>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('deals_delete')): ?>
            <button type="submit" class="btn <?php echo e(themeButton()); ?> m-sm" value="bulk-delete">
                <span class=""><?php echo e(svg_image('solid/trash-alt')); ?> <?php echo trans('app.'.'delete'); ?></span>
            </button>
            <?php endif; ?>

        </form>
    </section>


</div>

<?php $__env->startPush('pagestyle'); ?>
<?php echo $__env->make('stacks.css.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
    $(function () {

        var table = $('#deals-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo e(route('deals.data')); ?>',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "filter": '<?php echo e($filter); ?>',
                }
            },
            order: [
                [0, "desc"]
            ],
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'chk',
                    name: 'chk',
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'deal_value',
                    name: 'deal_value'
                },
                {
                    data: 'stage',
                    name: 'category.name'
                },
                {
                    data: 'organization',
                    name: 'company.name'
                },
                {
                    data: 'contact_person',
                    name: 'contact.name'
                },
                {
                    data: 'due_date',
                    name: 'due_date'
                },
            ]
        });


        $("#frm-deal button").click(function (ev) {
            ev.preventDefault();
            if ($(this).attr("value") == "bulk-email") {
                var form = $("#frm-deal").serialize();
                $("#frm-deals").submit();
            }

            if ($(this).attr("value") == "bulk-archive") {
                var form = $("#frm-deal").serialize();
                axios.post('<?php echo e(route('archive.process')); ?>', form)
                    .then(function (response) {
                        toastr.warning(response.data.message, '<?php echo trans('app.'.'response_status'); ?>');
                        window.location.href = response.data.redirect;
                    })
                    .catch(function (error) {
                        showErrors(error);
                    });
            }

            if ($(this).attr("value") == "bulk-delete") {
                var form = $("#frm-deal").serialize();
                axios.post('<?php echo e(route('deals.bulk.delete')); ?>', form)
                    .then(function (response) {
                        toastr.warning(response.data.message, '<?php echo trans('app.'.'response_status'); ?>');
                        window.location.href = response.data.redirect;
                    })
                    .catch(function (error) {
                        showErrors(error);
                    });
            }


        });

        function showErrors(error) {
            var errors = error.response.data.errors;
            var errorsHtml = '';
            $.each(errors, function (key, value) {
                errorsHtml += '<li>' + value[0] + '</li>';
            });
            toastr.error(errorsHtml, '<?php echo trans('app.'.'response_status'); ?>');
        }


    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /var/www/project-manager/Modules/Deals/Providers/../Resources/views/table_view.blade.php ENDPATH**/ ?>