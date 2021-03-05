<div class="">
    @if ($project->client_id <= 0) <div class="alert alert-danger">
        <button class="close" data-dismiss="alert" type="button">×</button>
        @icon('solid/info-circle') {{ __('No Client attached to this project.') }}
</div>
@endif

<div>
    <strong>
        @langapp('progress')
    </strong>
    <div class="pull-right">
        <strong class="{{ ($project->progress < 100) ? 'text-danger' : 'text-success' }}">
            {{ $project->progress }}%
        </strong>
    </div>
</div>
<div class="progress-xxs mb-0 {{ ($project->progress != '100') ? 'progress-striped' : '' }} progress">
    <div class="progress-bar progress-bar-{{ get_option('theme_color') }} " data-original-title="{{ $project->progress }}%" data-toggle="tooltip"
        style="width: {{ $project->progress }}%">
    </div>
</div>

@asyncWidget('Projects.TimerChart', ['project' => $project->id])


<div class="row m-t-sm">
    <div class="border-r border-gray-200 col-lg-4">
        <div class="my-1">

            <small class="text-sm text-gray-600 uppercase">@langapp('name')</small>
            <div class="font-semibold text-gray-600 uppercase">{{ $project->name }}</div>

            @can('projects_view_clients')
            @if ($project->client_id > 0)
            <div class="line"></div>
            <small class="text-sm text-gray-600 uppercase">@langapp('client')</small>
            <div class="font-semibold text-indigo-500 uppercase">
                <a href="{{  route('clients.view', $project->client_id)  }}">{{ $project->company->name }}</a>
            </div>
            @endif
            @endcan

            @if ($project->deal_id > 0)
            <div class="line"></div>
            <small class="text-sm text-gray-600 uppercase">@langapp('deal')</small>
            <div class="font-semibold text-indigo-500 uppercase">
                <a href="{{  route('deals.view', $project->deal_id)  }}">{{ optional($project->deal)->name }}</a>
            </div>

            @endif

            @if ($project->contract_id > 0)
            <div class="line"></div>
            <small class="text-sm text-gray-600 uppercase">@langapp('contract')</small>
            <div class="font-semibold text-indigo-500 uppercase">
                <a href="{{  route('contracts.view', $project->contract_id)  }}">{{ $project->contract->contract_title }}</a>
            </div>

            @endif

            <div class="line"></div>
            <div class="text-sm text-gray-600 uppercase">@langapp('information')</div>
            <div class="py-1">
                <span class="text-gray-600">@langapp('start_date'): </span>
                <span class="font-semibold text-gray-600">{{ $project->start_date->toDayDateTimeString()  }}</span>
            </div>

            <div class="py-1">
                <span class="text-gray-600">@langapp('due_date'): </span>
                @if (!empty($project->due_date))

                <span class="font-semibold text-gray-600">{{ dateTimeFormatted($project->due_date)  }}
                    @if (time() > strtotime($project->due_date) && $project->progress < 100) <span class="badge bg-danger">
                        @langapp('overdue')
                </span>
                @endif
                </span>
                @else
                @langapp('ongoing')
                @endif
            </div>

            @if ($project->progress < 100) <div class="py-1">
                <span class="text-gray-600">
                    @langapp('deadline'):
                </span>
                <span class="font-semibold text-gray-600">
                    {{ (time() > strtotime($project->due_date)) ? '- ' : '' }}
                    {{ dueInDays($project->due_date) }} @langapp('days')
                </span>
        </div>
        @endif

        <div class="py-1">
            <span class="text-gray-600">@langapp('status'): </span>
            <span class="font-semibold text-gray-600">{{ $project->status }}</span>
        </div>


        @can('projects_view_cost')
        <div class="line"></div>
        <small class="text-sm text-gray-600 uppercase">@langapp('cost')</small>
        <div class="py-1">
            <span class="text-gray-600">@langapp('estimated_hours'): </span>
            <span class="font-semibold text-gray-600">{{ $project->estimate_hours }}
                <small>@langapp('hours')</small></span>
        </div>

        <div class="py-1">
            <span class="text-gray-600">@langapp('hourly_rate'): </span>
            <span class="font-semibold text-gray-600">{{ $project->hourly_rate }}<small>/hr</small></span>
        </div>

        <div class="py-1">
            <span class="text-gray-600">@langapp('estimated_price'): </span>
            <span class="font-semibold text-gray-600">{{  formatCurrency($project->currency, $project->estimate_hours *  $project->hourly_rate) }}</span>
        </div>

        <div class="py-1">
            <span class="text-gray-600">@langapp('used_budget'): </span>
            <span class="font-semibold {{ ($project->used_budget > 100) ? 'text-red-400' : 'text-green-500' }}">
                {{ $project->used_budget }}%
            </span>
        </div>

        @endcan

        @can('projects_view_expenses')
        <div class="line"></div>
        <small class="text-sm text-gray-600 uppercase">@langapp('expenses')</small>
        <div class="py-1">
            <span class="text-gray-600">@langapp('unbilled'): </span>
            <span class="font-semibold text-gray-600">{{ formatCurrency($project->currency, $project->unbilled_expenses) }}</span>
        </div>
        <div class="py-1">
            <span class="text-gray-600">@langapp('billed'): </span>
            <span class="font-semibold text-gray-600">{{ formatCurrency($project->currency, $project->billed_expenses) }}</span>
        </div>
        @endcan


        @widget('CustomFields\Extras', ['custom' => $project->custom])


        <div class="line"></div>
        @if($project->isTeam() || isAdmin() || can('projects_view_team'))
        <div class="text-sm text-gray-600 uppercase">@langapp('team_members')</div>

        <ul class="my-2 media-list">
            @foreach ($project->assignees as $member)
            <li class="p-2 mt-1 bg-gray-200 rounded-sm">
                <span class="text-gray-600 pull-right">
                    @icon('regular/clock', 'text-primary') {{ $member->user->profile->hourly_rate }}/ hr

                    @if(isAdmin() || Auth::id() == $project->manager)
                    <a href="{{ route('teams.manager', ['project' => $project->id, 'member' => $member->user->id]) }}" class="m-r-xs" data-toggle="tooltip"
                        title="Project Manager">@icon('solid/user-tie',
                        $member->user->id == $project->manager ? 'text-danger' : 'text-gray-600')</a>
                    @endif

                    @if(isAdmin() || Auth::id() == $project->manager)
                    <a href="{{ route('teams.remove', ['project' => $project->id, 'member' => $member->user->id]) }}" data-toggle="ajaxModal">@icon('regular/trash-alt')</a>
                    @endif

                </span>
                <span class="pull-left thumb-xs">
                    <a href="{{route('users.view',$member->user->id)}}">
                        <img alt="" class="img-sm img-circle" src="{{ $member->user->profile->photo }}">
                    </a>
                </span>
                <div class="ml-1 media-body media-middle">
                    <span class="ml-1 font-semibold text-gray-600">{{ str_limit($member->user->name,15) }}</span>
                    <div class="ml-2 media-annotation">
                        {{ $member->user->profile->job_title }}
                    </div>
                </div>
            </li>
            @endforeach
        </ul>

        @endif

        <div class="text-sm text-gray-600 uppercase">
            @langapp('vaults')
            <a href="{{ route('extras.vaults.create', ['module' => 'projects', 'id' => $project->id]) }}" class="btn btn-xs btn-danger pull-right"
                data-toggle="ajaxModal">@icon('solid/plus')</a>
        </div>
        <div class="line"></div>
        @widget('Vaults\Show', ['vaults' => $project->vault])

        @if($project->isTeam() || isAdmin())

        <div class="text-sm text-gray-600 uppercase">@langapp('tags')</div>
        @php
        $data['tags'] = $project->tags;
        @endphp
        @include('partial.tags', $data)
        @endif


        <div class="py-2 text-sm text-gray-600 uppercase">@langapp('description')</div>
        <div class="line"></div>
        <div class="mt-1 text-sm prose-lg with-responsive-img">

            @parsedown($project->description)
        </div>

    </div>
</div>
<div class="col-lg-8">
    <div class="row">

        @widget('Projects.BudgetChart', ['project' => $project])
        @widget('Projects.TaskChart', ['project' => $project])
        @widget('Projects.ExpenseChart', ['project' => $project])

    </div>

    <section class="panel panel-default">
        <header class="panel-heading">@langapp('activities') </header>

        @widget('Activities\Feed', ['activities' => $project->activities->take(40)])

    </section>
</div>
</div>
</div>

@push('pagescript')
<script>
    $(function () {
    $('.deleteConfirm').click(function (e) {
        e.preventDefault();
        if (window.confirm("Are you sure?")) {
            location.href = this.href;
        }
    });
});
</script>
@endpush