<div class="row">
    <div class="col-sm-4">
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">@langapp('active') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ getCalculated('tasks_active') }}
                    </span>
                </div>
            </div>
        </section>


        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">@langapp('done') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ getCalculated('tasks_done') }}
                    </span>
                </div>
            </div>
        </section>


        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">@langapp('overdue') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ getCalculated('tasks_overdue') }}
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">Avg. @langapp('progress') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ percent(getCalculated('tasks_average_progress')) }}%
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">Avg. @langapp('time_spent') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ secToHours(getCalculated('tasks_average_time')) }}
                    </span>
                </div>
            </div>
        </section>
    </div>


    <div class="col-md-8 b-top">
        @widget('Tasks\YearlyOverview')
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
                $janTasks = getCalculated('tasks_done_1_'.$year);
                $febTasks = getCalculated('tasks_done_2_'.$year);
                $marTasks = getCalculated('tasks_done_3_'.$year);
                $semOne = array($janTasks, $febTasks, $marTasks);
                @endphp
                <div class="clearfix m-b-md">{{ langdate('cal_january') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $janTasks }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_february') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $febTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_march') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $marTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-700">
                        <strong>
                            {{ array_sum($semOne) }} @langapp('tasks')
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
                $aprTasks = getCalculated('tasks_done_4_'.$year);
                $mayTasks = getCalculated('tasks_done_5_'.$year);
                $junTasks = getCalculated('tasks_done_6_'.$year);
                $semTwo = array($aprTasks, $mayTasks, $junTasks);
                @endphp

                <div class="clearfix m-b-md">{{ langdate('cal_april') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $aprTasks }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_may') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $mayTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_june') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $junTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-700">
                        <strong>
                            {{ array_sum($semTwo) }} @langapp('tasks')
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
                $julTasks = getCalculated('tasks_done_7_'.$year);
                $augTasks = getCalculated('tasks_done_8_'.$year);
                $sepTasks = getCalculated('tasks_done_9_'.$year);
                $semThree = array($julTasks, $augTasks, $sepTasks);
                @endphp
                <div class="clearfix m-b-md">{{ langdate('cal_july') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $julTasks }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_august') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $augTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_september') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $sepTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-600">
                        <strong>
                            {{ array_sum($semThree) }} @langapp('tasks')
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
                $octTasks = getCalculated('tasks_done_10_'.$year);
                $novTasks = getCalculated('tasks_done_11_'.$year);
                $decTasks = getCalculated('tasks_done_12_'.$year);
                $semFour = array($octTasks, $novTasks, $decTasks);
                @endphp

                <div class="clearfix m-b-md">{{ langdate('cal_october') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $octTasks }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_november') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $novTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_december') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $decTasks }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-600">
                        <strong>
                            {{ array_sum($semFour) }} @langapp('tasks')
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>