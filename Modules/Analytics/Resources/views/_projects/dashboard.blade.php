<div class="row">
    <div class="col-sm-4">
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">@langapp('active') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ getCalculated('projects_active') }}
                    </span>
                </div>
            </div>
        </section>


        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">@langapp('done') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ getCalculated('projects_done') }}
                    </span>
                </div>
            </div>
        </section>


        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">Avg. @langapp('used_budget') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ percent(getCalculated('projects_average_budget')) }}%
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">Avg. @langapp('progress') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ round(getCalculated('projects_average_progress'),2) }}%
                    </span>
                </div>
            </div>
        </section>
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear">
                    <span class="text-gray-700">Avg. @langapp('expenses') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('projects_average_expenses')

                    </span>
                </div>
            </div>
        </section>

    </div>

    <div class="col-md-8 b-top">
        @widget('Projects\TaskProjectChart')
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
                $janProjects = getCalculated('projects_done_1_'.$year);
                $febProjects = getCalculated('projects_done_2_'.$year);
                $marProjects = getCalculated('projects_done_3_'.$year);
                $semOne = array($janProjects, $febProjects, $marProjects);
                @endphp
                <div class="clearfix m-b-md">{{ langdate('cal_january') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $janProjects }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_february') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $febProjects }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_march') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $marProjects }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-700">
                        <strong>
                            {{ array_sum($semOne) }} @langapp('projects')
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
                $aprProjects = getCalculated('projects_done_4_'.$year);
                $mayProjects = getCalculated('projects_done_5_'.$year);
                $junProjects = getCalculated('projects_done_6_'.$year);
                $semTwo = array($aprProjects, $mayProjects, $junProjects);
                @endphp

                <div class="clearfix m-b-md">{{ langdate('cal_april') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $aprProjects }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_may') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $mayProjects }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_june') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $junProjects }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-700">
                        <strong>
                            {{ array_sum($semTwo) }} @langapp('projects')
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
                $julProjects = getCalculated('projects_done_7_'.$year);
                $augProjects = getCalculated('projects_done_8_'.$year);
                $sepProjects = getCalculated('projects_done_9_'.$year);
                $semThree = array($julProjects, $augProjects, $sepProjects);
                @endphp
                <div class="clearfix m-b-md">{{ langdate('cal_july') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $julProjects }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_august') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $augProjects }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_september') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $sepProjects }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-700">
                        <strong>
                            {{ array_sum($semThree) }} @langapp('projects')
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
                $octProjects = getCalculated('projects_done_10_'.$year);
                $novProjects = getCalculated('projects_done_11_'.$year);
                $decProjects = getCalculated('projects_done_12_'.$year);
                $semFour = array($octProjects, $novProjects, $decProjects);
                @endphp

                <div class="clearfix m-b-md">{{ langdate('cal_october') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $octProjects }}</div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_november') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $novProjects }}
                    </div>
                </div>

                <div class="clearfix m-b-md">{{ langdate('cal_december') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ $decProjects }}
                    </div>
                </div>

                <div class="clearfix m-b-md">
                    <div class="pull-right text-gray-700">
                        <strong>
                            {{ array_sum($semFour) }} @langapp('projects')
                        </strong>
                    </div>
                </div>

            </div>

        </div>

    </div>


</div>