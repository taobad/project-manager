<div class="row">

    <div class="col-sm-4">

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('tickets') </span>
                    <span class="block text-gray-600 pull-right m-l font-semibold">
                        {{ getCalculated('tickets_total') }}
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('open') </span>
                    <span class="block text-danger pull-right m-l font-semibold">
                        {{ getCalculated('tickets_open') }}
                    </span>
                </div>
            </div>
        </section>


        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('closed') </span>
                    <span class="block text-success pull-right m-l font-semibold">
                        {{ getCalculated('tickets_closed') }}
                    </span>
                </div>
            </div>
        </section>




        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('this_month') </span>
                    <span class="block text-gray-600 pull-right m-l font-semibold">
                        {{ getCalculated('tickets_this_month') }}
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">Avg. @langapp('time_spent') </span>
                    <span class="block text-gray-600 pull-right m-l font-semibold">
                        {{ round(getCalculated('tickets_avg_response'), 3) }}
                    </span>
                </div>
            </div>
        </section>




    </div>


    <div class="col-md-8 b-top">

        @widget('Tickets\YearlyChartWidget')

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
                $janTasks = getCalculated('tickets_1_'.$year);
                $febTasks = getCalculated('tickets_2_'.$year);
                $marTasks = getCalculated('tickets_3_'.$year);
                $semOne = array($janTasks, $febTasks, $marTasks);
                @endphp
                <div class="clearfix m-b-md span">{{ langdate('cal_january') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $janTasks }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_february') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $febTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_march') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $marTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ array_sum($semOne) }} @langapp('tickets')
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
                $aprTasks = getCalculated('tickets_4_'.$year);
                $mayTasks = getCalculated('tickets_5_'.$year);
                $junTasks = getCalculated('tickets_6_'.$year);
                $semTwo = array($aprTasks, $mayTasks, $junTasks);
                @endphp

                <div class="clearfix m-b-md span">{{ langdate('cal_april') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $aprTasks }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_may') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $mayTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_june') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $junTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ array_sum($semTwo) }} @langapp('tickets')
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
                $julTasks = getCalculated('tickets_7_'.$year);
                $augTasks = getCalculated('tickets_8_'.$year);
                $sepTasks = getCalculated('tickets_9_'.$year);
                $semThree = array($julTasks, $augTasks, $sepTasks);
                @endphp
                <div class="clearfix m-b-md span">{{ langdate('cal_july') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $julTasks }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_august') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $augTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_september') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $sepTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ array_sum($semThree) }} @langapp('tickets')
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
                $octTasks = getCalculated('tickets_10_'.$year);
                $novTasks = getCalculated('tickets_11_'.$year);
                $decTasks = getCalculated('tickets_12_'.$year);
                $semFour = array($octTasks, $novTasks, $decTasks);
                @endphp

                <div class="clearfix m-b-md span">{{ langdate('cal_october') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $octTasks }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_november') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $novTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_december') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $decTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ array_sum($semFour) }} @langapp('tickets')
                    </div>
                </div>

            </div>

        </div>

    </div>


</div>