<a href="{{ route('reports.view', ['type' => 'reports', 'm' => 'timesheets']) }}" class="btn {{themeButton()}}">
        @icon('solid/chart-line') @langapp('reports')
</a>
<a href="{{ route('reports.view', ['type' => 'cards', 'm' => 'timesheets']) }}" class="btn {{themeButton()}}">
        @icon('solid/user-clock') @langapp('timecards')
</a>