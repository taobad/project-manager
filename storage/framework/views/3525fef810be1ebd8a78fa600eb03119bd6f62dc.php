<div class="col-lg-12">
	<section class="panel panel-default">
		<form id="frm-lead" action="<?php echo e(route('leads.bulk.email')); ?>" method="POST">
			<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			<input type="hidden" name="module" value="leads">
			<div class="table-responsive">
				<table class="table table-striped" id="leads-table">
					<thead>
						<tr>
							<th class="hide"></th>
							<th class="no-sort">
								<label>
									<input name="select_all" value="1" id="select-all" type="checkbox" />
									<span class="label-text"></span>
								</label>
							</th>
							<th class=""><?php echo trans('app.'.'name'); ?> </th>
							<th class=""><?php echo trans('app.'.'company_name'); ?> </th>
							<th class=""><?php echo trans('app.'.'stage'); ?></th>
							<th class="col-currency"><?php echo trans('app.'.'lead_value'); ?></th>
							<th class=""><?php echo trans('app.'.'sales_rep'); ?></th>
							<th class=""><?php echo trans('app.'.'email'); ?> </th>
						</tr>
					</thead>
				</table>
			</div>
			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('leads_create')): ?>
			<button type="submit" id="button" class="btn <?php echo e(themeButton()); ?> m-xs" value="bulk-email">
				<span class=""><?php echo e(svg_image('solid/mail-bulk')); ?> <?php echo trans('app.'.'send_email'); ?></span>
			</button>
			<?php endif; ?>
			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('leads_create')): ?>
			<button type="submit" id="button" class="btn <?php echo e(themeButton()); ?> m-xs" value="bulk-sms">
				<span class=""><?php echo e(svg_image('solid/sms')); ?> <?php echo trans('app.'.'send'); ?> SMS</span>
			</button>
			<?php endif; ?>
			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('leads_update')): ?>
			<button type="submit" id="button" class="btn <?php echo e(themeButton()); ?> m-xs" value="bulk-archive">
				<span class=""><?php echo e(svg_image('solid/archive')); ?> <?php echo trans('app.'.'archive'); ?></span>
			</button>
			<?php endif; ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('leads_delete')): ?>
			<button type="submit" id="button" class="btn <?php echo e(themeButton()); ?> m-xs" value="bulk-delete">
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
	$(function() {
	$('#leads-table').DataTable({
	processing: true,
	serverSide: true,
	ajax: {
		url: '<?php echo e(route('leads.data')); ?>',
		type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	},
		data: {
			"filter": '<?php echo e($filter); ?>',
		}
	},
	order: [[ 0, "desc" ]],
	columns: [
	{ data: 'id', name: 'id' },
	{ data: 'chk', name: 'chk', searchable: false },
	{ data: 'name', name: 'name' },
	{ data: 'company', name: 'company' },
	{ data: 'stage', name: 'status.name' },
	{ data: 'lead_value', name: 'lead_value' },
	{ data: 'sales_rep', name: 'agent.name' },
	{ data: 'email', name: 'email' }
	]
	});
	$("#frm-lead button").click(function(ev){
	ev.preventDefault();
	if($(this).attr("value") == "bulk-email"){
		var form = $("#frm-lead").serialize();
		axios.post('<?php echo e(route('leads.bulk.email')); ?>', form)
	    .then(function (response) {
	    	$("#frm-lead").submit();
	    })
	    .catch(function (error) {
	    	showErrors(error);
	    });
		
	}
	if($(this).attr("value") == "bulk-sms"){
		var form = $("#frm-lead").serialize();
		axios.post('<?php echo e(route('leads.bulk.sms')); ?>', form)
	    .then(function (response) {
	    	$('#frm-lead').attr('action', "<?php echo e(route('leads.bulk.sms')); ?>").submit();
	    })
	    .catch(function (error) {
	    	showErrors(error);
	    });
		
	}

	if($(this).attr("value") == "bulk-archive"){
	    var form = $("#frm-lead").serialize();
	    axios.post('<?php echo e(route('archive.process')); ?>', form)
	    .then(function (response) {
	    toastr.warning(response.data.message, '<?php echo trans('app.'.'response_status'); ?> ');
	    window.location.href = response.data.redirect;
	    })
	    .catch(function (error) {
	    	showErrors(error);
	    });
	}

if($(this).attr("value")=="bulk-delete"){
    var form = $("#frm-lead").serialize();
    axios.post('<?php echo e(route('leads.bulk.delete')); ?>', form)
    .then(function (response) {
    toastr.warning(response.data.message, '<?php echo trans('app.'.'response_status'); ?> ');
    window.location.href = response.data.redirect;
    })
    .catch(function (error) {
    	showErrors(error);
    });
    }
});

	function showErrors(error){
	    var errors = error.response.data.errors;
	    var errorsHtml= '';
	    $.each( errors, function( key, value ) {
	    errorsHtml += '<li>' + value[0] + '</li>';
	    });
	    toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
	}
	
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH /var/www/project-manager/Modules/Leads/Providers/../Resources/views/table_view.blade.php ENDPATH**/ ?>