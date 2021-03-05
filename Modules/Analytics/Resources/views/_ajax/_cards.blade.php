<div class="table-responsive">
    <table id="table-timesheet" class="table table-striped">
        <thead>
            <tr>
                <th>@langapp('team_member')</th>
                <th>@langapp('hourly_rate')</th>
                <th>@langapp('time_spent')</th>
                <th>@langapp('cost')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $entry)
            @php
                $hours = $entry->user->workedHours($start_date,$end_date);
                $cost = $hours * $entry->user->profile->hourly_rate;
            @endphp
            <tr>
                <td><a href="{{ route('users.view', ['user' => $entry->user_id, 'tab' => 'timesheet']) }}">{{ $entry->user->name }}</a></td>
                <td>{{ get_option('default_currency_symbol') }} {{ $entry->user->profile->hourly_rate }}/hr</td>
                <td class="text-semibold">{{ $hours }} @langapp('hours') </td>
                <td class="text-semibold">{{ get_option('default_currency_symbol') }} {{ $cost }}</td>
            </tr>
            
            @endforeach

        </tbody>
    </table>

</div>
@push('pagestyle')
@include('stacks.css.datatables')
@endpush
@push('pagescript')
@include('stacks.js.datatables')
<script>
$('#table-timesheet').DataTable({
processing: true,
order: [[ 0, "desc" ]],
pageLength: 25
});
</script>
@endpush
@stack('pagestyle')
@stack('pagescript')