<div class="row">

    <div class="col-sm-4">

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('billed') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('expenses_billed')

                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('unbillable') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('expenses_unbillable')
                    </span>
                </div>
            </div>
        </section>


        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('this_year') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('expenses_year_'.$year)
                    </span>
                </div>
            </div>
        </section>


        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('this_month') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('expenses_this_month')
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('last_month') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('expenses_last_month')
                    </span>
                </div>
            </div>
        </section>






    </div>


    <div class="col-md-8 b-top">

        @widget('Expenses\BillableChart')

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
                $janExpenses = getCalculated('expenses_billable_1_'.$year);
                $febExpenses = getCalculated('expenses_billable_2_'.$year);
                $marExpenses = getCalculated('expenses_billable_3_'.$year);
                $semOne = array($janExpenses, $febExpenses, $marExpenses);
                @endphp
                <div class="clearfix m-b-md span">{{ langdate('cal_january') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $janExpenses) }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_february') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $febExpenses) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_march') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $marExpenses) }}
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
                $aprExpenses = getCalculated('expenses_billable_4_'.$year);
                $mayExpenses = getCalculated('expenses_billable_5_'.$year);
                $junExpenses = getCalculated('expenses_billable_6_'.$year);
                $semTwo = array($aprExpenses, $mayExpenses, $junExpenses); @endphp

                <div class="clearfix m-b-md span">{{ langdate('cal_april') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $aprExpenses) }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_may') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $mayExpenses) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_june') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $junExpenses) }}
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
                $julExpenses = getCalculated('expenses_billable_7_'.$year);
                $augExpenses = getCalculated('expenses_billable_8_'.$year);
                $sepExpenses = getCalculated('expenses_billable_9_'.$year);
                $semThree = array($julExpenses, $augExpenses, $sepExpenses); @endphp
                <div class="clearfix m-b-md span">{{ langdate('cal_july') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $julExpenses) }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_august') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $augExpenses) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_september') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $sepExpenses) }}
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
                $octExpenses = getCalculated('expenses_billable_10_'.$year);
                $novExpenses = getCalculated('expenses_billable_11_'.$year);
                $decExpenses = getCalculated('expenses_billable_12_'.$year);
                $semFour = array($octExpenses, $novExpenses, $decExpenses); @endphp

                <div class="clearfix m-b-md span">{{ langdate('cal_october') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $octExpenses) }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_november') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $novExpenses) }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_december') }}
                    <div class="pull-right text-gray-600 font-semibold">
                        {{ formatCurrency(get_option('default_currency'), $decExpenses) }}
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