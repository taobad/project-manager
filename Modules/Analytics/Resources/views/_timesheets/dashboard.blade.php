<div class="row">
    <div class="col-sm-4">
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('billable') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ secToHours(getCalculated('time_billable')) }}
                    </span>
                </div>
            </div>
        </section>
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('unbillable') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ secToHours(getCalculated('time_unbillable')) }}
                    </span>
                </div>
            </div>
        </section>
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('billed') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ secToHours(getCalculated('time_billed')) }}
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('unbilled') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ secToHours(getCalculated('time_unbilled')) }}
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('total_time') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ secToHours(getCalculated('time_worked')) }}
                    </span>
                </div>
            </div>
        </section>
    </div>

    <div class="col-md-8 b-top">
        @widget('Timetracking\YearlyOverview')
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
                $janEntries = getCalculated('time_worked_1_'.$year);
                $febEntries = getCalculated('time_worked_2_'.$year);
                $marEntries = getCalculated('time_worked_3_'.$year);
                $semOne = array($janEntries, $febEntries, $marEntries);
                @endphp
                <div class="clearfix m-b-md">{{ langdate('cal_january') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $janEntries }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_february') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $febEntries }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_march') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $marEntries }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-700">
                        <strong>{{ secToHours(array_sum($semOne)) }}</strong>
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
                $aprEntries = getCalculated('time_worked_4_'.$year);
                $mayEntries = getCalculated('time_worked_5_'.$year);
                $junEntries = getCalculated('time_worked_6_'.$year);
                $semTwo = array($aprEntries, $mayEntries, $junEntries);
                @endphp

                <div class="clearfix m-b-md">{{ langdate('cal_april') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ secToHours($aprEntries) }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_may') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ secToHours($mayEntries) }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_june') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ secToHours($junEntries) }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-700">
                        <strong>{{ secToHours(array_sum($semTwo)) }}</strong>
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
                $julEntries = getCalculated('time_worked_7_'.$year);
                $augEntries = getCalculated('time_worked_8_'.$year);
                $sepEntries = getCalculated('time_worked_9_'.$year);
                $semThree = array($julEntries, $augEntries, $sepEntries);
                @endphp
                <div class="clearfix m-b-md">{{ langdate('cal_july') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ secToHours($julEntries) }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_august') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ secToHours($augEntries) }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_september') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ secToHours($sepEntries) }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-700">
                        <strong>{{ secToHours(array_sum($semThree)) }}</strong>
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
                $octEntries = getCalculated('time_worked_10_'.$year);
                $novEntries = getCalculated('time_worked_11_'.$year);
                $decEntries = getCalculated('time_worked_12_'.$year);
                $semFour = array($octEntries, $novEntries, $decEntries);
                @endphp

                <div class="clearfix m-b-md">{{ langdate('cal_october') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ secToHours($octEntries) }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_november') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ secToHours($novEntries) }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_december') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ secToHours($decEntries) }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-700">
                        <strong>{{ secToHours(array_sum($semFour)) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>