<div class="">

    <div class="grid grid-cols-1 mt-5 overflow-hidden bg-white rounded-lg shadow md:grid-cols-3">
        <div>
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('outstanding')">
                        @langapp('outstanding')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{ Auth::user()->profile->company > 0 ? formatCurrency(get_option('default_currency'), Auth::user()->profile->business->due()) : 'N/A' }}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                {{ get_option('default_currency') }}
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-orange-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-file-invoice"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900">
                        <span data-toggle="tooltip" title="@langapp('paid')">@langapp('paid')</span>
                        (<span class="text-xs text-gray-700" data-toggle="tooltip" title="@langapp('credits')">
                            @langapp('credits') :
                            {{Auth::user()->profile->company > 0 ? formatCurrency(get_option('default_currency'), Auth::user()->profile->business->creditBalance()) : 'N/A' }}
                        </span>)
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{ Auth::user()->profile->company > 0 ? formatCurrency(get_option('default_currency'), Auth::user()->profile->business->amountPaid()) : 'N/A' }}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                {{ get_option('default_currency') }}
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-green-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-receipt"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('overdue')">
                        @langapp('overdue')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{ Auth::user()->profile->company > 0 ? formatCurrency(get_option('default_currency'), Auth::user()->profile->business->overdue()) : 'N/A' }}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                {{ get_option('default_currency') }}
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