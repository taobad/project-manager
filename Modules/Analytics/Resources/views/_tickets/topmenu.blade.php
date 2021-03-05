<div class="btn-group">

    <button class="btn {{themeButton()}} dropdown-toggle" data-toggle="dropdown">
        Type
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="{{ route('reports.view', ['type' => 'performance', 'm' => 'tickets']) }}">@langapp('agent_performance')</a></li>
        <li><a href="{{ route('reports.view', ['type' => 'happiness', 'm' => 'tickets']) }}">@langapp('feedback')</a></li>
        <li><a href="{{ route('reports.view', ['type' => 'helpdocs', 'm' => 'tickets']) }}">@langapp('knowledgebase')</a></li>
        <li><a href="{{ route('reports.view', ['type' => 'busiest', 'm' => 'tickets']) }}">@langapp('busiest_days')</a></li>
    </ul>
</div>


<a href="{{ route('reports.view', ['type' => 'reports', 'm' => 'tickets']) }}" class="btn {{themeButton()}}">
    @icon('solid/chart-line') @langapp('reports')
</a>