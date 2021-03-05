<div class="col-lg-4">
    <section class="panel panel-default">
        <header class="panel-heading">
            @langapp('budget')
        </header>
        <div class="panel-body text-center">
            <div class="text-gray-600 font-semibold">
                {{ secToHours($project->billable_time) }}
            </div>
            <small class="text-gray-600 block">
                @langapp('estimated_hours') {{ $project->estimate_hours }}
            </small>
            <div class="inline">
                <div class="easypiechart" data-bar-color="#5a67d8" data-line-width="16" data-loop="false"
                    data-percent="{{ percent($project->used_budget) }}" data-size="150">
                    <span class="h2 step">
                        {{ percent($project->used_budget) }}
                    </span>
                    %
                    <div class="easypie-text">
                        @langapp('used')
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="text-sm">
                @icon('solid/chart-line', 'text-success')
                {{ $project->used_budget > 100 ? 'Over Budget' : 'On Budget' }}
            </div>
        </div>
    </section>
</div>