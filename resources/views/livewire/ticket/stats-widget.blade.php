<div class="px-3 py-1 border-b">

    <div class="mt-1 grid grid-cols-1 bg-white overflow-hidden md:grid-cols-3">
        <div>
            <div class="px-4 py-3 sm:p-3">
                <dl>
                    <dt class="text-sm font-normal text-gray-600 uppercase">
                        @langapp('open')
                    </dt>
                    <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                        <div class="flex items-baseline text-2xl leading-8 font-semibold text-indigo-500">
                            {{ getCalculated('tickets_open') }}
                            <span class="ml-2 text-sm leading-5 font-medium text-gray-500">
                                @langapp('tickets')
                            </span>
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="">
            <div class="px-4 py-3 sm:p-3">
                <dl>
                    <dt class="text-sm font-normal text-gray-600 uppercase">
                        @langapp('closed')
                    </dt>
                    <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                        <div class="flex items-baseline text-2xl leading-8 font-semibold text-green-500">
                            {{ getCalculated('tickets_closed') }}
                            <span class="ml-2 text-sm leading-5 font-medium text-gray-500">
                                @langapp('tickets')
                            </span>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="">
            <div class="px-4 py-3 sm:p-3">
                <dl>
                    <dt class="text-sm font-normal text-gray-600 uppercase">
                        @langapp('response_time')
                    </dt>
                    <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                        <div class="flex items-baseline text-2xl leading-8 font-semibold text-red-500">
                            {{ round(getCalculated('tickets_avg_response'), 2) }}
                            <span class="ml-2 text-sm leading-5 font-medium text-gray-500">
                                @langapp('hours')
                            </span>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>