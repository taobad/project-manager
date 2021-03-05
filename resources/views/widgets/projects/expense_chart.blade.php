<div class="col-lg-4">
    <section class="panel panel-default">
        <header class="panel-heading">
            @langapp('expenses')
        </header>
        <div class="panel-body text-center">
            <div class="text-gray-600 font-semibold">
                {{ formatCurrency($project->currency, $project->unbilled_expenses) }}
            </div>
            <div class="text-gray-600 block">
                @langapp('unbilled')
            </div>
            <div class="inline">
                <div class="easypiechart" data-bar-color="#5a67d8" data-line-cap="butt" data-line-width="30" data-percent="{{ percent($project->expensesPercent()) }}"
                    data-scale-color="#fff" data-size="150" data-track-color="#eee">
                    <span class="h2 step font25">
                        {{ percent($project->expensesPercent()) }}
                    </span>%
                    <div class="easypie-text">
                        @langapp('billed')
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="text-sm">
                @icon('regular/credit-card')
                @langapp('total') <span class="text-gray-600 font-semibold">{{ formatCurrency($project->currency, $project->expenses->sum('amount')) }}</span>
            </div>

        </div>
    </section>
</div>