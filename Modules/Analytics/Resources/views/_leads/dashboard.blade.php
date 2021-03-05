<div class="row">
    <div class="col-sm-4">
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('leads') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ getCalculated('leads_total') }}
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('converted')</span>
                    <span class="block pull-right m-l text-indigo-600 font-semibold">
                        {{ getCalculated('leads_converted') }}

                    </span>
                </div>
            </div>
        </section>
        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('this_month') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ getCalculated('leads_this_month') }}
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('last_month') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        {{ getCalculated('leads_last_month') }}
                    </span>
                </div>
            </div>
        </section>

        <section class="panel panel-info">
            <div class="panel-body">
                <div class="clear text-sm">
                    <span class="text-gray-700">@langapp('lead_value') </span>
                    <span class="block pull-right m-l text-gray-700 font-semibold">
                        @metrics('leads_value')

                    </span>
                </div>
            </div>
        </section>


    </div>


    <div class="col-md-8 b-top">

        @widget('Leads\YearlyOverview')

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
                $janLeads = getCalculated('leads_1_'.$year);
                $febLeads = getCalculated('leads_2_'.$year);
                $marLeads = getCalculated('leads_3_'.$year);
                $semOne = array($janLeads, $febLeads, $marLeads);
                @endphp
                <div class="clearfix m-b-md span">{{ langdate('cal_january') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $janLeads }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_february') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $febLeads }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_march') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $marLeads }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        <strong>
                            {{ array_sum($semOne) }} @langapp('leads')
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
                $aprLeads = getCalculated('leads_4_'.$year);
                $mayLeads = getCalculated('leads_5_'.$year);
                $junLeads = getCalculated('leads_6_'.$year);
                $semTwo = array($aprLeads, $mayLeads, $junLeads);
                @endphp

                <div class="clearfix m-b-md span">{{ langdate('cal_april') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $aprLeads }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_may') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $mayLeads }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_june') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $junLeads }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        <strong>
                            {{ array_sum($semTwo) }} @langapp('leads')
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
                $julLeads = getCalculated('leads_7_'.$year);
                $augLeads = getCalculated('leads_8_'.$year);
                $sepLeads = getCalculated('leads_9_'.$year);
                $semThree = array($julLeads, $augLeads, $sepLeads);
                @endphp
                <div class="clearfix m-b-md span">{{ langdate('cal_july') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $julLeads }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_august') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $augLeads }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_september') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $sepLeads }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        <strong>
                            {{ array_sum($semThree) }} @langapp('leads')
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
                $octLeads = getCalculated('leads_10_'.$year);
                $novLeads = getCalculated('leads_11_'.$year);
                $decLeads = getCalculated('leads_12_'.$year);
                $semFour = array($octLeads, $novLeads, $decLeads);
                @endphp

                <div class="clearfix m-b-md span">{{ langdate('cal_october') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $octLeads }}</div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_november') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $novLeads }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">{{ langdate('cal_december') }}
                    <div class="pull-right text-gray-700 font-semibold">
                        {{ $decLeads }}
                    </div>
                </div>

                <div class="clearfix m-b-md span">
                    <div class="pull-right text-gray-700 font-semibold">
                        <strong>
                            {{ array_sum($semFour) }} @langapp('leads')
                        </strong>
                    </div>
                </div>

            </div>

        </div>

    </div>


</div>