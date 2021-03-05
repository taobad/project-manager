<div class="row">

    <div class="col-sm-4">
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">@langapp('accepted') </span>
                    <span class="block pull-right m-l text-indigo-600 font-semibold">
                        @metrics('estimates_accepted')
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">@langapp('declined') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('estimates_rejected')
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">@langapp('this_month') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('estimates_this_month')
                    </span>
                </div>
            </div>
        </section>


        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">@langapp('last_month') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('estimates_last_month')
                    </span>
                </div>
            </div>
        </section>
    </div>

    <div class="col-md-8 b-top">
        @widget('Estimates\YearlyOverview')
    </div>

</div>


<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title text-gray-600">1st @langapp('quarter') , {{ $year }}</h4>
            </header>

            <hr class="widget-separator">
            <div class="widget-body p-t-lg">
                @php
                $janEstimates = getCalculated('estimates_1_'.$year);
                $febEstimates = getCalculated('estimates_2_'.$year);
                $marEstimates = getCalculated('estimates_3_'.$year);
                $semOne = array($janEstimates, $febEstimates, $marEstimates); @endphp
                <div class="clearfix m-b-md span">{{ langdate('cal_january') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $janEstimates) }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_february') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $febEstimates) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_march') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $marEstimates) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700">
                        <strong>
                            {{ formatCurrency(get_option('default_currency'), array_sum($semOne)) }}
                        </strong>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <div class="col-md-3 col-sm-6">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title text-gray-600">2nd @langapp('quarter') , {{ $year }}</h4>
            </header>

            <hr class="widget-separator">
            <div class="widget-body p-t-lg">
                @php
                $aprEstimates = getCalculated('estimates_4_'.$year);
                $mayEstimates = getCalculated('estimates_5_'.$year);
                $junEstimates = getCalculated('estimates_6_'.$year);
                $semTwo = array($aprEstimates, $mayEstimates, $junEstimates);
                @endphp

                <div class="clearfix m-b-md span">{{ langdate('cal_april') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $aprEstimates) }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_may') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $mayEstimates) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_june') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $junEstimates) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700">
                        <strong>
                            {{ formatCurrency(get_option('default_currency'), array_sum($semTwo)) }}
                        </strong>
                    </div>
                </div>

            </div>

        </div>

    </div>



    <div class="col-md-3 col-sm-6">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title text-gray-600">3rd @langapp('quarter') , {{ $year }}</h4>
            </header>

            <hr class="widget-separator">
            <div class="widget-body p-t-lg">
                @php
                $julEstimates = getCalculated('estimates_7_'.$year);
                $augEstimates = getCalculated('estimates_8_'.$year);
                $sepEstimates = getCalculated('estimates_9_'.$year);
                $semThree = array($julEstimates, $augEstimates, $sepEstimates);
                @endphp
                <div class="clearfix m-b-md span">{{ langdate('cal_july') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $julEstimates) }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_august') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $augEstimates) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_september') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $sepEstimates) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700">
                        <strong>
                            {{ formatCurrency(get_option('default_currency'), array_sum($semThree)) }}
                        </strong>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <div class="col-md-3 col-sm-6">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title text-gray-600">4th @langapp('quarter') , {{ $year }}</h4>
            </header>

            <hr class="widget-separator">
            <div class="widget-body p-t-lg">
                @php
                $octEstimates = getCalculated('estimates_10_'.$year);
                $novEstimates = getCalculated('estimates_11_'.$year);
                $decEstimates = getCalculated('estimates_12_'.$year);
                $semFour = array($octEstimates, $novEstimates, $decEstimates);
                @endphp

                <div class="clearfix m-b-md span">{{ langdate('cal_october') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $octEstimates) }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_november') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $novEstimates) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_december') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $decEstimates) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700">
                        <strong>
                            {{ formatCurrency(get_option('default_currency'), array_sum($semFour)) }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>