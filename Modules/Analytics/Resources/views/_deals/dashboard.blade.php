<div class="row">

    <div class="col-sm-4">
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('won_deals') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('deals_won')
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('lost') </span>
                    <span class="block pull-right m-l text-red-600 font-semibold">
                        @metrics('deals_lost')

                    </span>
                </div>
            </div>
        </section>


        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('this_month') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">

                        @metrics('deals_this_month')

                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('last_month') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('deals_last_month')
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('sales_velocity') </span>
                    <span class="block text-primary pull-right m-l text-gray-700 font-semibold">
                        {{ getCalculated('sales-velocity') }}
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('conversion_rate') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ round(getCalculated('conversion-rate'),2) }}%
                    </span>
                </div>
            </div>
        </section>









    </div>


    <div class="col-md-8 b-top">

        @widget('Deals\WonLostChart')

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
                $janDeals = getCalculated('deals_1_'.$year);
                $febDeals = getCalculated('deals_2_'.$year);
                $marDeals = getCalculated('deals_3_'.$year);
                $semOne = array($janDeals, $febDeals, $marDeals);
                @endphp
                <div class="clearfix m-b-md span">{{ langdate('cal_january') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $janDeals }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_february') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $febDeals }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_march') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $marDeals }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ array_sum($semOne) }} @langapp('deals')
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
                $aprDeals = getCalculated('deals_4_'.$year);
                $mayDeals = getCalculated('deals_5_'.$year);
                $junDeals = getCalculated('deals_6_'.$year);
                $semTwo = array($aprDeals, $mayDeals, $junDeals); @endphp

                <div class="clearfix m-b-md span">{{ langdate('cal_april') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $aprDeals }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_may') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $mayDeals }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_june') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $junDeals }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ array_sum($semTwo) }} @langapp('deals')
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
                $julDeals = getCalculated('deals_7_'.$year);
                $augDeals = getCalculated('deals_8_'.$year);
                $sepDeals = getCalculated('deals_9_'.$year);
                $semThree = array($julDeals, $augDeals, $sepDeals); @endphp
                <div class="clearfix m-b-md span">{{ langdate('cal_july') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $julDeals }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_august') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $augDeals }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_september') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $sepDeals }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ array_sum($semThree) }} @langapp('deals')
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
                $octDeals = getCalculated('deals_10_'.$year);
                $novDeals = getCalculated('deals_11_'.$year);
                $decDeals = getCalculated('deals_12_'.$year);
                $semFour = array($octDeals, $novDeals, $decDeals); @endphp

                <div class="clearfix m-b-md span">{{ langdate('cal_october') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $octDeals }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_november') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $novDeals }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_december') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $decDeals }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ array_sum($semFour) }} @langapp('deals')
                    </div>
                </div>

            </div>

        </div>

    </div>


</div>