<div class="modal-dialog">
    <div class="modal-content">
        <div class="p-2 border-b border-gray-300">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="text-xl text-gray-600 modal-title">
                @langapp('invoice_project')
            </h4>
        </div>

        {!! Form::open(['route' => ['projects.api.invoice', $project->id], 'class' => 'bs-example form-horizontal ajaxifyForm']) !!}

        <input type="hidden" name="id" value="{{ $project->id }}">
        <div class="modal-body">

            <div class="py-1">
                <span class="text-gray-600">@langapp('invoice_project') : </span>
                <span class="{{themeText('font-semibold')}}">{{ $project->name }}</span>
            </div>
            <div class="py-1">
                <span class="text-gray-600">@langapp('unbilled') : </span>
                <span class="font-bold text-gray-600">{{ secToHours($project->unbilled) }}</span>
            </div>

            <div class="py-1">
                <span class="text-gray-600">@langapp('expenses') : </span>
                <span class="font-bold text-gray-600">{{ formatCurrency($project->currency, $project->unbilled_expenses) }}</span>
            </div>

            <div class="m-sm">
                <label>
                    <input type="radio" name="invoice_style" value="single">
                    <span class="label-text">
                        @langapp('single_line') - <span class="text-gray-600">Project displays in a single invoice item</span>
                    </span>
                </label>
            </div>

            <div class="m-sm">
                <label>
                    <input type="radio" name="invoice_style" value="task_line" checked>
                    <span class="label-text">@langapp('task_per_line') - <span class="text-muted">List tasks as invoice items</span></span>
                </label>
            </div>


            @php
            $expenses = $project->expenses->where('invoiced', 0);
            @endphp

            @if (count($expenses) > 0)
            <h3 class="py-2 text-sm text-gray-600">@langapp('include_expenses') </h3>
            @foreach ($expenses as $key => $expense)


            <div class="form-group">
                <div class="text-gray-600 col-lg-12">
                    <div class="col-md-1">
                        <label>
                            <input type="checkbox" class="form-control" name="expense[{{ $expense->id }}]" value="1">
                            <span class="label-text"></span>
                        </label>

                    </div>

                    <div class="col-md-6">
                        @langapp('cost') :
                        <strong class="text-indigo-600">{{ formatCurrency($expense->currency, $expense->cost) }}</strong><br>
                        @langapp('project') : <strong>{{ $project->name }}</strong><br>
                        @langapp('category') : <strong>{{ $expense->AsCategory->name }}</strong><br>

                    </div>

                    <div class="col-md-5">
                        @langapp('expense_date') :
                        <strong>{{ dateFormatted($expense->expense_date) }}</strong><br>
                        @langapp('notes') : <strong class="text-ellipsis">
                            @parsedown($expense->notes)
                        </strong>

                    </div>

                </div>

            </div>
            <div class="line line-dashed line-lg pull-in"></div>


            @endforeach


            @endif

            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                @langapp('time_entries_marked_as_billed')
            </div>



        </div>
        <div class="modal-footer">

            {!! closeModalButton() !!}
            {!! renderAjaxButton() !!}

        </div>
        {!! Form::close() !!}
    </div>
</div>

@include('partial.ajaxify')