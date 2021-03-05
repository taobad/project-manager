<header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
    <div class="flex justify-between text-gray-500">
        <div>
            <div class="btn-group">
                <button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown">
                    @icon('solid/sort') @langapp('filter')
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ url('/projects/view/'.$project->id.'/timesheets?filter=all') }}">@langapp('all')</a>
                    </li>
                    <li>
                        <a href="{{ url('/projects/view/'.$project->id.'/timesheets?filter=billable') }}">@langapp('invoiceable')
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/projects/view/'.$project->id.'/timesheets?filter=unbillable') }}">@langapp('noninvoiceable')
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/projects/view/'.$project->id.'/timesheets?filter=billed') }}">@langapp('billed')
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/projects/view/'.$project->id.'/timesheets?filter=unbilled') }}">@langapp('unbilled')
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/projects/view/'.$project->id.'/timesheets?filter=active') }}">@langapp('active')
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div>
            @if ($project->isTeam() || isAdmin())
            <a href="{{  route('timetracking.create', ['module' => 'projects', 'id' => $project->id])  }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                @icon('solid/plus') @langapp('create')
            </a>
            @endif
        </div>
    </div>
</header>

<form id="frm-timesheet" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="url" value="{{ url()->full() }}">
    <div class="table-responsive">
        <table id="timesheet-table" class="table table-striped">
            <thead>
                <tr>
                    <th class="hide"></th>
                    <th class="no-sort">
                        <label>
                            <input name="select_all" value="1" id="select-all" type="checkbox" />
                            <span class="label-text"></span>
                        </label>
                    </th>
                    <th class="">@langapp('name') </th>
                    <th class="">@langapp('user')</th>
                    <th class="">@langapp('total_time') </th>
                    <th class="col-date">@langapp('start') </th>
                    <th class="col-date">@langapp('stop') </th>
                    <th class="col-date">@langapp('date') </th>
                    <th class="no-sort"></th>
                </tr>
            </thead>

        </table>
        @if(isAdmin() || can('timer_delete'))
        <button type="submit" class="btn m-1 {{themeButton()}}" value="bulk-delete">
            <span class="" data-toggle="tooltip" title="Delete Selected">
                @icon('solid/trash-alt') @langapp('delete')
            </span>
        </button>
        @endif

</form>
</div>
@push('pagestyle')
@include('stacks.css.datatables')
@endpush
@push('pagescript')
@include('stacks.js.datatables')
<script>
    $(function() {
    $('#timesheet-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('timetracking.all', ['project' => $project->id])!!}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "filter": '{{ $filter }}',
            }
        },
        order: [[ 0, "desc" ]],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'chk', name: 'chk', orderable: false, searchable: false, sortable: false },
            { data: 'name', name: 'name', searchable: false  },
            { data: 'user', name: 'user.name', orderable: false},
            { data: 'total_time', name: 'total'},
            { data: 'start', name: 'start' },
            { data: 'stop', name: 'end' },
            { data: 'date', name: 'created_at'},
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $("#frm-timesheet button").click(function(ev){
        ev.preventDefault();
        if($(this).attr("value")=="bulk-delete"){
            var form = $("#frm-timesheet").serialize();
            axios.post('{{ route('timers.api.bulk.delete') }}', form).then(function (response) {
                toastr.warning(response.data.message, '@langapp('response_status') ');
                window.location.href = response.data.redirect;
            })
            .catch(function (error) {
                    showErrors(error);
                });
        }   
        function showErrors(error){
        var errors = error.response.data.errors;
        var errorsHtml= '';
        $.each( errors, function( key, value ) {
            errorsHtml += '<li>' + value[0] + '</li>';
        });
            toastr.error( errorsHtml , '@langapp('response_status') ');
        }
});

});
</script>
@endpush