<div class="row proj-summary-band">
    @if (can('projects_update') || $project->isTeam())
    <div class="text-center col-md-3 animated fadeInRightBig">
        <div class="text-gray-600 uppercase">
            @langapp('cost')
        </div>
        <div class="{{themeText('font-semibold')}}">
            {{ humanize($project->billing_method) }}
        </div>
        @can('projects_view_cost')
        <div class="text-xl font-semibold text-gray-600">
            {{ formatCurrency($project->currency, $project->sub_total) }}
        </div>
        @endcan
    </div>
    <div class="text-center col-md-3 animated fadeInRightBig">
        <div class="text-gray-600 uppercase">
            @langapp('unbilled')
        </div>
        @can('projects_view_expenses')
        <div class="{{themeText('font-semibold text-sm')}}">
            + {{ formatCurrency($project->currency, $project->unbilled_expenses) }} @langapp('expenses')
        </div>
        <div class="text-xl font-semibold text-gray-600">
            {{ secToHours($project->unbilled)  }}
        </div>
        @endcan
    </div>
    <div class="text-center col-md-3 animated fadeInRightBig">
        <div class="text-gray-600 uppercase">
            @langapp('invoiceable')
        </div>
        <div class="{{themeText('font-semibold text-sm')}}">
            {{  gmsec($project->billable_time)  }}
        </div>
        <div class="text-xl font-semibold text-gray-600">
            {{  secToHours($project->billable_time)  }}
        </div>
    </div>
    <div class="text-center col-md-3 animated fadeInRightBig">
        <div class="text-gray-600 uppercase">
            @langapp('noninvoiceable')
        </div>
        <div class="{{themeText('font-semibold text-sm')}}">
            {{  gmsec($project->unbillable_time)  }}
        </div>
        <div class="text-xl font-semibold text-gray-600">
            {{ secToHours($project->unbillable_time) }}
        </div>
    </div>
    @endif
</div>