<div class="">

    <div class="grid grid-cols-1 mt-5 overflow-hidden bg-white rounded-lg shadow md:grid-cols-3">
        <div>
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('credits')">
                        @langapp('credits')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            @metrics('credits_open')
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
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('receipts')">
                        @langapp('receipts')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            @metrics('total_receipts')
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                {{ get_option('default_currency') }}
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-green-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-check-circle"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('outstanding')">
                        @langapp('outstanding')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            @metrics('outstanding_balance')
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



<div class="flex m-2 justify-evenly">
    <div class="px-3 py-2 border border-transparent text-sm leading-4 rounded-full text-white {{themeBg()}} hover:bg-indigo-600 focus:outline-none focus:border-indigo-700">
        <a href="/analytics?m=payments" class="hover:text-white"> <i class="mr-2 fas fa-chart-line"></i> View complete
            Report </a>
    </div>

</div>