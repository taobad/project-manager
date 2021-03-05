<a href="{{ route('reports.view', ['type' => 'reports', 'm' => 'projects']) }}" class="btn {{themeButton()}}">
    @icon('solid/chart-line') @langapp('reports')
</a>

<div class="btn-group">

    <button class="btn {{themeButton()}} dropdown-toggle" data-toggle="dropdown">
        Type
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="{{ route('reports.view', ['type' => 'feedback', 'm' => 'projects']) }}">@langapp('feedback')</a></li>
    </ul>
</div>