<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/tasks') @langapp('convert_to_task')</h4>
        </div>
        {!! Form::open(['route' => ['tickets.task.create', $ticket->id], 'class' => 'bs-example form-horizontal ajaxifyForm']) !!}
        <div class="modal-body prose-lg text-sm">
            <input type="hidden" name="id" value="{{ $ticket->id }}">

            <p>Ticket <strong>{{ $ticket->subject }}</strong> will be converted to project task</p>

            <div class="line"></div>


            <div class="form-group">
                <label class="col-md-4 control-label">@langapp('project') @required</label>
                <div class="col-md-8">
                    <select name="project_id" class="form-control select2-option">
                        @foreach (Auth::user()->assignments()->where('assignable_type', Modules\Projects\Entities\Project::class)->get() as $assigned)
                        <option value="{{ $assigned->assignable_id }}">{{ $assigned->assignable->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


        </div>
        <div class="modal-footer">

            {!! closeModalButton() !!}

            {!! renderAjaxButton('ok') !!}

        </div>

        {!! Form::close() !!}
    </div>
</div>

@push('pagestyle')
@include('stacks.css.form')
@endpush
@push('pagescript')
@include('stacks.js.form')
@include('partial.ajaxify')
@endpush

@stack('pagestyle')
@stack('pagescript')