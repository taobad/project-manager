<div class="row">
	<?php $counter = 0; ?>
	<?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if(!(($counter++) % 2)): ?>
</div>
<div class="row">
	<?php endif; ?>
	<div class="col-md-6">
		<div class="panel invoice-grid widget-b">
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<h3 class="text-ellipsis">
							<a href="<?php echo e(route('contracts.view', ['contract' => $contract->id])); ?>" class="<?php echo e(themeLinks('text-lg font-semibold')); ?>">
								<?php echo e($contract->contract_title); ?>

							</a>
						</h3>
						<ul class="list list-unstyled">
							<li>
								<a class="<?php echo e(themeLinks('font-semibold')); ?>" href="<?php echo e(route('clients.view', ['client' => $contract->client_id])); ?>">
									<?php echo e(optional($contract->company)->name); ?>

								</a>
							</li>
							<li><?php echo trans('app.'.'start_date'); ?> :
								<span class="">
									<?php echo e(dateFormatted($contract->start_date)); ?>

								</span>
							</li>
							<li>Template :
								<span class="text-bold">
									<?php echo e(str_limit($contract->template->name, 20)); ?>

								</span>
							</li>
						</ul>
					</div>
					<div class="col-sm-6">
						<?php if($contract->rate_is_fixed == '1'): ?>
						<?php
						$rate = formatCurrency($contract->currency, $contract->fixed_rate);
						?>
						<?php else: ?>
						<?php
						$rate = formatCurrency($contract->currency, $contract->hourly_rate).'/hr';
						?>
						<?php endif; ?>
						<h4 class="text-xl font-semibold text-right text-gray-600"><?php echo e($rate); ?></h4>
						<ul class="text-right list list-unstyled">
							<li><?php echo trans('app.'.'signed'); ?>:
								<span class="text-success">
									<?php echo e(($contract->signed == '1') ? langapp('yes') : langapp('no')); ?></span>
							</li>
							<li><?php echo trans('app.'.'status'); ?>:
								<span class="label label-danger"><?php echo e($contract->status); ?></span>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="panel-footer panel-footer-condensed">
				<a class="heading-elements-toggle"></a>
				<div class="heading-elements">
					<span class="heading-text">
						<span class="status-mark border-danger position-left"></span> <?php echo trans('app.'.'due_date'); ?> :
						<span class="font-semibold text-gray-700"><?php echo e(dateFormatted($contract->expiry_date)); ?></span>
					</span>
					<div class="btn-group btn-group-animated pull-right">
						<button type="button" class="btn <?php echo e(themeButton()); ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<?php echo e(svg_image('solid/ellipsis-h')); ?>
						</button>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo e(route('contracts.download', $contract->id)); ?>">
									<?php echo e(svg_image('solid/file-pdf')); ?> PDF
								</a>
							</li>

							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contracts_sign')): ?>
							<?php if($contract->signed == '0'): ?>
							<li>
								<a href="<?php echo e(route('contracts.send', $contract->id)); ?>" data-toggle="ajaxModal">
									<?php echo e(svg_image('solid/paper-plane')); ?> <?php echo trans('app.'.'sign_send'); ?>
								</a>
							</li>
							<?php endif; ?>

							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contract_update')): ?>
							<li>
								<a href="<?php echo e(route('contracts.share', $contract->id)); ?>" data-toggle="ajaxModal">
									<?php echo e(svg_image('solid/link')); ?> <?php echo trans('app.'.'share'); ?>
								</a>
							</li>
							<?php endif; ?>

							<?php endif; ?>

							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contracts_create')): ?>
							<li>
								<a href="<?php echo e(route('contracts.copy', $contract->id)); ?>" data-toggle="ajaxModal">
									<?php echo e(svg_image('solid/copy')); ?> <?php echo trans('app.'.'copy'); ?>
								</a>
							</li>
							<?php endif; ?>

							<?php if(!is_null($contract->sent_at)): ?>
							<li>
								<a href="<?php echo e(route('contracts.remind', $contract->id)); ?>" data-toggle="ajaxModal">
									<?php echo e(svg_image('solid/history')); ?> <?php echo trans('app.'.'reminder'); ?>
								</a>
							</li>
							<?php endif; ?>

							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contracts_update')): ?>
							<li>
								<a href="<?php echo e(route('contracts.edit', $contract->id)); ?>">
									<?php echo e(svg_image('solid/pencil-alt')); ?> <?php echo trans('app.'.'make_changes'); ?>
								</a>
							</li>
							<?php endif; ?>
							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contracts_delete')): ?>
							<li>
								<a href="<?php echo e(route('contracts.delete', $contract->id)); ?>" data-toggle="ajaxModal">
									<?php echo e(svg_image('solid/trash-alt')); ?> <?php echo trans('app.'.'delete'); ?>
								</a>
							</li>
							<?php endif; ?>

						</ul>
					</div>


				</div>
			</div>
		</div>
	</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH /var/www/project-manager/Modules/Contracts/Providers/../Resources/views/_ajax/_contracts.blade.php ENDPATH**/ ?>