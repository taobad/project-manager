<div class="row">
	<div class="col-sm-4">
		<section class="panel panel-info">
			<div class="panel-body">
				<div class="clear text-sm">
					<span class="text-gray-700">@langapp('total_sales') </span>
					<span class="block pull-right m-l text-indigo-600 font-semibold">
						@metrics('invoiced_total')
					</span>
				</div>
			</div>
		</section>

		<section class="panel panel-info">
			<div class="panel-body">
				<div class="clear text-sm">
					<span class="text-gray-700">@langapp('outstanding') </span>
					<span class="block pull-right m-l text-red-600 font-semibold">
						@metrics('outstanding_balance')
					</span>
				</div>
			</div>
		</section>


		<section class="panel panel-info">
			<div class="panel-body">
				<div class="clear text-sm">
					<span class="text-gray-700">@langapp('this_year') </span>
					<span class="block pull-right m-l text-gray-700 font-semibold">
						@metrics('invoiced_year_'.$year)
					</span>
				</div>
			</div>
		</section>


		<section class="panel panel-info">
			<div class="panel-body">
				<div class="clear text-sm">
					<span class="text-gray-700">@langapp('this_month') </span>
					<span class="block pull-right m-l text-gray-700 font-semibold">
						@metrics('invoiced_this_month')
					</span>
				</div>
			</div>
		</section>

		<section class="panel panel-info">
			<div class="panel-body">
				<div class="clear text-sm">
					<span class="text-gray-700">@langapp('last_month') </span>
					<span class="block pull-right m-l text-gray-700 font-semibold">
						@metrics('invoiced_last_month')
					</span>
				</div>
			</div>
		</section>
	</div>

	<div class="col-md-8 b-top">
		@widget('Invoices\InvoicingChart')
	</div>

</div>


<div class="row">

	{{-- first quarter --}}
	<div class="col-md-3 col-sm-6">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title text-gray-600">1st @langapp('quarter') , {{ $year }}</h4>
			</header>
			<hr class="widget-separator">
			<div class="widget-body p-t-lg">
				@php
				$janSales = getCalculated('invoiced_1_'.$year);
				$febSales = getCalculated('invoiced_2_'.$year);
				$marSales = getCalculated('invoiced_3_'.$year);
				$semOne = array($janSales, $febSales, $marSales); @endphp
				<div class="clearfix m-b-md span">{{ langdate('cal_january') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $janSales) }}</div>
				</div>

				<div class="clearfix m-b-md span">{{ langdate('cal_february') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $febSales) }}
					</div>
				</div>

				<div class="clearfix m-b-md span">{{ langdate('cal_march') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $marSales) }}
					</div>
				</div>

				<div class="clearfix m-b-md span">
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), array_sum($semOne)) }}
					</div>
				</div>

			</div>
		</div>
	</div>

	{{-- second quarter --}}
	<div class="col-md-3 col-sm-6">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title text-gray-600">2nd @langapp('quarter') , {{ $year }}</h4>
			</header>
			<hr class="widget-separator">
			<div class="widget-body p-t-lg">
				@php
				$aprSales = getCalculated('invoiced_4_'.$year);
				$maySales = getCalculated('invoiced_5_'.$year);
				$junSales = getCalculated('invoiced_6_'.$year);
				$semTwo = array($aprSales, $maySales, $junSales);
				@endphp

				<div class="clearfix m-b-md span">{{ langdate('cal_april') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $aprSales) }}</div>
				</div>

				<div class="clearfix m-b-md span">{{ langdate('cal_may') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $maySales) }}
					</div>
				</div>

				<div class="clearfix m-b-md span">{{ langdate('cal_june') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $junSales) }}
					</div>
				</div>

				<div class="clearfix m-b-md span">
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), array_sum($semTwo)) }}
					</div>
				</div>

			</div>
		</div>
	</div>

	{{-- third quarter --}}

	<div class="col-md-3 col-sm-6">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title text-gray-600">3rd @langapp('quarter') , {{ $year }}</h4>
			</header>
			<hr class="widget-separator">
			<div class="widget-body p-t-lg">
				@php
				$julSales = getCalculated('invoiced_7_'.$year);
				$augSales = getCalculated('invoiced_8_'.$year);
				$sepSales = getCalculated('invoiced_9_'.$year);
				$semThree = array($julSales, $augSales, $sepSales);
				@endphp
				<div class="clearfix m-b-md span">{{ langdate('cal_july') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $julSales) }}</div>
				</div>

				<div class="clearfix m-b-md span">{{ langdate('cal_august') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $augSales) }}
					</div>
				</div>

				<div class="clearfix m-b-md span">{{ langdate('cal_september') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $sepSales) }}
					</div>
				</div>

				<div class="clearfix m-b-md span">
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), array_sum($semThree)) }}
					</div>
				</div>

			</div>
		</div>
	</div>
	{{-- fourth quarter --}}

	<div class="col-md-3 col-sm-6">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title text-gray-600">4th @langapp('quarter') , {{ $year }}</h4>
			</header>
			<hr class="widget-separator">
			<div class="widget-body p-t-lg">
				@php
				$octSales = getCalculated('invoiced_10_'.$year);
				$novSales = getCalculated('invoiced_11_'.$year);
				$decSales = getCalculated('invoiced_12_'.$year);
				$semFour = array($octSales, $novSales, $decSales);
				@endphp

				<div class="clearfix m-b-md span">{{ langdate('cal_october') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $octSales) }}</div>
				</div>

				<div class="clearfix m-b-md span">{{ langdate('cal_november') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $novSales) }}
					</div>
				</div>

				<div class="clearfix m-b-md span">{{ langdate('cal_december') }}
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), $decSales) }}
					</div>
				</div>

				<div class="clearfix m-b-md span">
					<div class="pull-right text-gray-700 font-semibold">
						{{ formatCurrency(get_option('default_currency'), array_sum($semFour)) }}
					</div>
				</div>

			</div>
		</div>
	</div>


</div>