<div class="">

    <div class="grid grid-cols-1 mt-5 overflow-hidden bg-white rounded-lg shadow md:grid-cols-3">
        <div>
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('total_time')">
                        @langapp('today')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{ toHours(Auth::user()->timesheet()->whereDate('created_at', today())->sum('total')) }}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                @langapp('hours')
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-green-500 md:mt-2 lg:mt-0">
                            <i class="far fa-clock"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900">
                        <span data-toggle="tooltip" title="@langapp('this_week')">@langapp('this_week')</span>
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{ toHours(Auth::user()->timesheet()->whereBetween('created_at', [now()->startOfWeek(),now()->endOfWeek()])->sum('total')) }}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                @langapp('hours')
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-green-500 md:mt-2 lg:mt-0">
                            <i class="far fa-calendar-check"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('leads')">
                        @langapp('leads')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{ Auth::user()->leads()->whereNull('converted_at')->count() }}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                @langapp('pending')
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-green-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-user-friends"></i>
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>