<header class="bg-<?php echo e(get_option('top_bar_color')); ?> header navbar navbar-fixed-top-xs nav-z">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">
                <?php echo e(svg_image('solid/bars')); ?>
            </a>
            <a href="<?php echo e(url('/')); ?>" class="navbar-brand <?php echo e(themeText()); ?>">
                <?php $display = get_option('logo_or_icon'); ?>
                <?php if($display == 'logo' || $display == 'logo_title'): ?>
                <img src="<?php echo e(getStorageUrl(config('system.media_dir').'/'.get_option('company_logo'))); ?>" class="mr-1">
                <?php elseif($display == 'icon' || $display == 'icon_title'): ?>
                <i class="fa <?php echo e(get_option('site_icon')); ?>"></i>
                <?php endif; ?>
                <?php if($display == 'logo_title' || $display == 'icon_title'): ?>
                <?php if(get_option('website_name') == ''): ?>
                <?php echo e(get_option('company_name')); ?>

                <?php else: ?>
                <?php echo e(get_option('website_name')); ?>

                <?php endif; ?>
                <?php endif; ?>
            </a>
            <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
                <?php echo e(svg_image('solid/cog')); ?>
            </a>
        </div>
        <ul class="nav navbar-nav hidden-xs" id="todolist">
            <li class="">

                <div class="m-t m-l-lg">
                    <?php if(\Auth::user()->tasksUpcoming() > 0): ?>
                    <a href="<?php echo e(route('tasks.upcoming')); ?>" class="" data-toggle="tooltip" title="<?php echo trans('app.'.'tasks'); ?>" data-placement="bottom">
                        <?php echo e(svg_image('solid/tasks')); ?>
                        <span class="bg-red-500 badge badge-sm up m-l-n-sm display-inline"><?php echo e(\Auth::user()->tasksUpcoming()); ?></span>
                    </a>
                    <?php endif; ?>
                    <?php if(\Auth::user()->todoToday() > 0): ?>
                    <a href="<?php echo e(route('calendar.todos')); ?>" class="" data-toggle="tooltip" title="<?php echo trans('app.'.'todo'); ?>" data-placement="bottom">
                        <?php echo e(svg_image('regular/check-circle')); ?>
                        <span class="bg-red-500 badge badge-sm up m-l-n-sm display-inline"><?php echo e(\Auth::user()->todoToday()); ?></span>
                    </a>
                    <?php endif; ?>

                    <?php if(Auth::user()->newchats->count()): ?>
                    <a href="<?php echo e(route('leads.index')); ?>" class="m-l" data-toggle="tooltip" title="WhatsApp" data-placement="bottom">
                        <?php echo e(svg_image('solid/comment-alt', 'fa-lg text-success')); ?>
                        <span class="badge badge-sm up bg-dracula m-l-n-sm display-inline"><?php echo e(Auth::user()->newchats->count()); ?></span>
                    </a>
                    <?php endif; ?>

                    <?php if (moduleActive('calendar')) { ?>

                    <a href="<?php echo e(route('calendar.appointments')); ?>" class="m-l" data-toggle="tooltip" title="<?php echo trans('app.'.'appointments'); ?> " data-placement="bottom">
                        <?php echo e(svg_image('solid/calendar-check')); ?>
                    </a>

                    <?php } ?>

                </div>

            </li>
        </ul>


        <ul class="nav navbar-nav navbar-right hidden-xs nav-user">

            <?php if(count(runningTimers()) > 0): ?>
            <li class="">
                <a href="<?php echo e(route('timetracking.timers')); ?>" title="<?php echo trans('app.'.'timers'); ?>" data-toggle="ajaxModal" data-toggle="tooltip" data-placement="bottom">
                    <i class="fas fa-sync-alt fa-spin fa-lg <?php echo e(themeText()); ?>"></i>
                    <span class="bg-blue-400 badge badge-sm up m-l-n-sm display-inline"><?php echo e(count(runningTimers())); ?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php echo $__env->make('partial.notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
            <li class="dropdown hidden-xs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" x-on:click="$refs.searchField.focus()">
                    <?php echo e(svg_image('solid/search', 'fa-fw')); ?>
                </a>
                <section class="dropdown-menu aside-xl animated fadeInUp">
                    <section class="bg-white panel">

                        <form action="<?php echo e(route('search.app')); ?>" method="POST" role="search">
                            <?php echo csrf_field(); ?>

                            <div class="flex w-full p-4 md:ml-0">
                                <label for="search_field" class="sr-only">Search</label>
                                <div class="relative w-full text-gray-500 focus-within:text-gray-600">
                                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 m-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"></path>
                                        </svg>
                                    </div>
                                    <input x-ref="searchField" x-on:keydown.window.prevent.slash="$refs.searchField.focus()" name="keyword" placeholder="Type and press Enter"
                                        class="block w-full h-full py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 bg-gray-200 rounded-md focus:outline-none focus:placeholder-gray-600 sm:text-sm">
                                </div>
                            </div>


                        </form>
                    </section>
                </section>
            </li>
            <?php endif; ?>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="thumb-sm avatar pull-left">
                        <img src="<?php echo e(avatar()); ?>" class="img-circle">
                    </span>
                    <?php echo e(Auth::user()->name); ?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInRight">
                    <li class="arrow top"></li>
                    <li><a href="<?php echo e(route('users.profile')); ?>"><?php echo trans('app.'.'settings'); ?> </a></li>
                    <li><a href="<?php echo e(route('users.reminders')); ?>"><?php echo trans('app.'.'reminders'); ?></a></li>
                    <li><a href="<?php echo e(route('users.notifications')); ?>"><?php echo trans('app.'.'notifications'); ?> </a></li>
                    <li><a href="<?php echo e(route('extras.user.templates')); ?>"><?php echo trans('app.'.'canned_responses'); ?></a></li>
                    <?php if(config('system.remote_support') && isAdmin()): ?>
                    <li><a href="<?php echo e(route('support.ticket')); ?>" data-toggle="ajaxModal">Need Help?</a></li>
                    <li><a href="<?php echo e(route('tell.friend')); ?>" data-toggle="ajaxModal"><?php echo trans('app.'.'tell_friend'); ?></a></li>
                    <?php endif; ?>
                    <li class="divider"></li>
                    <?php if(Auth::user()->isImpersonating()): ?>
                    <li><a href="<?php echo e(route('users.stopimpersonate')); ?>"><?php echo trans('app.'.'stop_impersonate'); ?></a></li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <?php echo e(svg_image('solid/sign-out-alt')); ?> Logout
                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="display-none">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</header><?php /**PATH /var/www/project-manager/resources/views/partial/top_header.blade.php ENDPATH**/ ?>