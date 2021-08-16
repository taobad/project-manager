<?php $__env->startSection('content'); ?>


<section id="content" class="wrapper-md content">


    <div id="login-darken"></div>
    <div id="login-form" class="container max-w-md aside-xxl animated fadeInUp">

        <span class="navbar-brand mt-8 font-semibold text-center text-2xl leading-8 block <?php echo e(settingEnabled('blur_login') ? 'text-white' : themeText()); ?>">
            <?php $display = get_option('logo_or_icon'); ?>
            <?php if($display == 'logo' || $display == 'logo_title'): ?>
            <img src="<?php echo e(getStorageUrl(config('system.media_dir').'/'.get_option('company_logo'))); ?>" class="img-responsive <?php echo e(($display == 'logo' ? '' : 'thumb-sm mr-1')); ?>">
            <?php elseif($display == 'icon' || $display == 'icon_title'): ?>
            <i class="<?php echo e(get_option('site_icon')); ?>"></i>
            <?php endif; ?>
            <?php if($display == 'logo_title' || $display == 'icon_title'): ?>
            <?php if(get_option('website_name') == ''): ?>
            <?php echo e(get_option('company_name')); ?>

            <?php else: ?>
            <?php echo e(get_option('website_name')); ?>

            <?php endif; ?>
            <?php endif; ?>
        </span>

        <section class="bg-white panel panel-default m-t-sm b-r-xs">
            <header class="px-2 py-3 text-center text-white <?php echo e(themeBg()); ?> border-b border-gray-200 rounded-t-sm"><?php echo e(get_option('login_title')); ?></header>

            <?php if(settingEnabled('enable_languages')): ?>
            <div class="clearfix text-right m-xs">

                <div class="btn-group dropdown">
                    <button type="button" class="dropdown-toggle <?php echo e(themeButton()); ?>" data-toggle="dropdown">
                        <?php echo e(svg_image('solid/globe')); ?> <?php echo trans('app.'.'languages'); ?>
                        <span class="caret"></span>
                    </button>

                    <!-- Load Languages -->
                    <ul class="text-left dropdown-menu">
                        <?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($lang['active'] == 1): ?>
                        <li>
                            <a href="<?php echo e(route('setLanguage', $lang['code'])); ?>" title="<?php echo e(ucwords(str_replace('_', ' ', $lang['name']))); ?>">
                                <?php echo e(ucwords(str_replace('_', ' ', $lang['name']))); ?>

                            </a>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <?php echo Form::open(['route' => 'register', 'class' => 'panel-body wrapper-lg']); ?>


            <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                <label for="name"><?php echo trans('app.'.'fullname'); ?> <span class="text-danger">*</span></label>
                <input id="name" type="text" class="form-control" name="name" placeholder="John Doe" value="<?php echo e(old('name')); ?>" required autofocus>

                <?php if($errors->has('name')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('name')); ?></strong>
                </span>
                <?php endif; ?>
            </div>

            <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                <label for="email"><?php echo trans('app.'.'contact_email'); ?> <span class="text-danger">*</span></label>
                <input id="email" type="email" class="form-control" placeholder="johndoe@example.com" name="email" value="<?php echo e(old('email')); ?>" required>

                <?php if($errors->has('email')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('email')); ?></strong>
                </span>
                <?php endif; ?>

            </div>

            <div class="form-group<?php echo e($errors->has('mobile') ? ' has-error' : ''); ?>">
                <label for="mobile"><?php echo trans('app.'.'mobile'); ?></label>
                <input id="mobile" type="text" class="form-control" placeholder="+14081234567" name="mobile" value="<?php echo e(old('mobile')); ?>" required>

                <?php if($errors->has('mobile')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('mobile')); ?></strong>
                </span>
                <?php endif; ?>

            </div>

            <div class="form-group<?php echo e($errors->has('company') ? ' has-error' : ''); ?>">
                <label for="company_name"><?php echo trans('app.'.'company_name'); ?></label>
                <input id="company_name" type="text" class="form-control" placeholder="ACME co," name="company" value="<?php echo e(old('company')); ?>" required>

                <?php if($errors->has('company')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('company')); ?></strong>
                </span>
                <?php endif; ?>

            </div>
            <div class="form-group<?php echo e($errors->has('company_email') ? ' has-error' : ''); ?>">
                <label for="company_email"><?php echo trans('app.'.'company_email'); ?> <span class="text-danger">*</span></label>
                <input id="email" type="email" class="form-control" placeholder="johndoe@company.com" name="company_email" value="<?php echo e(old('company_email')); ?>" required>

                <?php if($errors->has('company_email')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('company_email')); ?></strong>
                </span>
                <?php endif; ?>

            </div>

            <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                <label for="password"><?php echo trans('app.'.'password'); ?> <span class="text-danger">*</span></label>

                <input id="password" type="password" class="form-control" name="password" required>

                <?php if($errors->has('password')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('password')); ?></strong>
                </span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password-confirm"><?php echo trans('app.'.'confirm_password'); ?> <span class="text-danger">*</span></label>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

            </div>

            <div class="form-group <?php echo e($errors->has('agree_terms') ? ' has-error' : ''); ?>">

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="agree_terms" <?php echo e(old('agree_terms') ? 'checked' : ''); ?>>
                        <span class="label-text">Agree to terms and <a href="<?php echo e(get_option('privacy_policy_url')); ?>" class="text-blue-600" target="_blank">privacy policy</a></span>
                    </label>
                </div>

                <?php if($errors->has('agree_terms')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('agree_terms')); ?></strong>
                </span>
                <?php endif; ?>

            </div>

            <button type="submit" class="btn <?php echo e(themeButton()); ?> btn-block">
                <?php echo e(svg_image('regular/check-circle')); ?> <?php echo trans('app.'.'register'); ?>
            </button>
            <a href="<?php echo e(route('login')); ?>" class="btn <?php echo e(themeButton()); ?> btn-block">
                <?php echo e(svg_image('solid/sign-in-alt')); ?>
                <?php echo trans('app.'.'login'); ?>
            </a>

            <?php echo Form::close(); ?>



            
            <?php if(!settingEnabled('hide_branding')): ?>
            <?php echo $__env->make('partial.branding', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            

        </section>

    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/project-manager/resources/views/auth/register.blade.php ENDPATH**/ ?>