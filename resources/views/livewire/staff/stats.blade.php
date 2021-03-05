<div class="">

    <div class="grid grid-cols-1 mt-5 overflow-hidden bg-white rounded-lg shadow md:grid-cols-3">
        <div>
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('pending')">
                        @langapp('tasks')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{ Auth::user()->assignments()->where('assignable_type', Modules\Tasks\Entities\Task::class)->whereHas('assignable', function ($query) {
                                return $query->where('progress', '<', 100);
                            })->count() }}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                @langapp('pending')
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-green-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-tasks"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900">
                        <span data-toggle="tooltip" title="@langapp('projects')">@langapp('projects')</span>

                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{ Auth::user()->assignments()->where('assignable_type', Modules\Projects\Entities\Project::class)->whereHas('assignable', function ($query) {
                                return $query->where('progress', '<', 100);
                            })->count() }}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                @langapp('pending')
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-green-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-project-diagram"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('tickets')">
                        @langapp('tickets')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{ Modules\Tickets\Entities\Ticket::where('assignee', Auth::id())->whereNull('closed_at')->count() }}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                @langapp('pending')
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-red-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>