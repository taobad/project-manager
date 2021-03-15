<div class="flex flex-col">
    <div class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
        <div class="text-gray-600">
            Per Page: &nbsp;
            <select wire:model="perPage" class="py-2 pr-2">
                <option>10</option>
                <option>15</option>
                <option>25</option>
            </select>
        </div>
        <div class="flex justify-between flex-1 sm:justify-end">
            <div class="relative md:w-1/3">
                <input wire:model="search" class="w-full py-2 pl-10 pr-2 font-medium text-gray-600 rounded-lg shadow focus:outline-none focus:shadow-outline" type="text"
                    placeholder="Search Tasks...">
                <div class="absolute top-0 left-0 inline-flex items-center p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <circle cx="10" cy="10" r="7" />
                        <line x1="21" y1="21" x2="15" y2="15" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                            <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                <?php echo trans('app.'.'name'); ?>
                                <?php echo $__env->make('partial._sort-icon', ['field' => 'name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </a>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                            <a wire:click.prevent="sortBy('project_id')" role="button" href="#">
                                <?php echo trans('app.'.'project'); ?>
                                <?php echo $__env->make('partial._sort-icon', ['field' => 'project_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </a>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                            <a wire:click.prevent="sortBy('start_date')" role="button" href="#">
                                <?php echo trans('app.'.'start_date'); ?>
                                <?php echo $__env->make('partial._sort-icon', ['field' => 'start_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </a>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                            <a wire:click.prevent="sortBy('due_date')" role="button" href="#">
                                <?php echo trans('app.'.'due_date'); ?>
                                <?php echo $__env->make('partial._sort-icon', ['field' => 'due_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </a>
                        </th>
                        <th class="hidden px-6 py-3 border-b border-gray-200 bg-gray-50 sm:block"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-white">
                        <td class="px-6 py-4 text-sm font-medium leading-5 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-semibold leading-5 truncate">
                                        <a href="<?php echo e(route('projects.view', ['project' => $task->project_id,'tab' => 'tasks','item'=>$task->id])); ?>" class="<?php echo e(themeLinks()); ?>">
                                            <?php echo e($task->name); ?>

                                        </a>
                                    </div>
                                    <div class="text-xs leading-5 text-gray-700">
                                        <?php echo e($task->user->name); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="m-1 progress progress-xxs">
                                <div class="progress-bar progress-bar-success" data-toggle="tooltip" title="<?php echo e($task->progress); ?>%" style="width: <?php echo e($task->progress); ?>%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-500 border-b border-gray-200">
                            <a href="<?php echo e(route('projects.view',['project' => $task->project_id])); ?>"
                                class="text-indigo-600"><?php echo e(str_limit(optional($task->AsProject)->name, 25)); ?></a>
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-700 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-semibold leading-5 text-gray-600">
                                        <?php echo e($task->start_date->toFormattedDateString()); ?>

                                    </div>
                                    <div class="text-xs leading-5 text-gray-700">
                                        <?php echo e($task->hourly_rate); ?>/hr
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-500 border-b border-gray-200">
                            <div class="ml-4">
                                <div class="text-sm font-semibold leading-5 text-gray-600">
                                    <?php echo e($task->due_date->toFormattedDateString()); ?>

                                </div>
                                <div class="text-xs leading-5 text-gray-700">
                                    <?php echo e(secToHours($task->total_time)); ?>

                                </div>
                            </div>
                        </td>
                        <td class="hidden px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-gray-200 sm:block">
                            <a href="<?php echo e(route('tasks.edit',$task->id)); ?>" data-toggle="ajaxModal" class="btn <?php echo e(themeButton()); ?>">Edit</a>
                        </td>
                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="px-4 py-2 text-gray-600">
                <?php echo e($tasks->links()); ?>

            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/project-manager/resources/views/livewire/task/index-table.blade.php ENDPATH**/ ?>