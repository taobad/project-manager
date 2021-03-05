<div class="col-lg-4">
    <section class="panel panel-default">
        <header class="panel-heading">
            @langapp('tasks')
        </header>
        <div class="panel-body text-center">
            <div class="text-gray-600 font-semibold">
                {{ $project->tasks->where('progress', '<', 100)->count() }}
                <small>
                    @langapp('pending')
                </small>
            </div>
            <div class="text-gray-600 block">
                {{ $project->tasks->where('progress', 100)->count() }} @langapp('done')
            </div>
            <div class="inline">
                <div class="easypiechart" data-bar-color="#5a67d8" data-line-width="6" data-loop="false"
                    data-percent="{{ percent($project->taskDonePercent()) }}" data-size="150">
                    <span class="h2 step">
                        {{ percent($project->taskDonePercent()) }}
                    </span>
                    %
                    <div class="easypie-text">
                        @langapp('done')
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="text-sm">
                @icon('solid/tasks')
                @langapp('tasks') <span class="text-gray-600 font-semibold">({{ $project->tasks->count() }})</span>
            </div>
        </div>
    </section>
</div>