<div class="modal-dialog">
    <div class="modal-content">
        <div class="p-2 border-b border-gray-300">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="text-xl text-gray-600 modal-title">
                @icon('regular/trash-alt') @langapp('delete')
            </h4>
        </div>

        {!! Form::open(['route' => ['projects.api.delete', $project->id], 'method' => 'DELETE', 'class' => 'ajaxifyForm']) !!}

        <div class="modal-body">
            <p>@langapp('delete_warning')</p>
            <p>
                @langapp('title') : <strong class="{{themeText()}}">{{ $project->name }}</strong><br>
                @langapp('expenses') : <strong>{{ formatCurrency($project->currency, $project->total_expenses) }}</strong><br>
                @langapp('cost') : <strong>{{ formatCurrency($project->currency, $project->sub_total) }}</strong><br>
            </p>

            <input type="hidden" name="id" value="{{  $project->id  }}">

        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            {!! renderAjaxButton('ok') !!}

        </div>

        {!! Form::close() !!}
    </div>
</div>

@include('partial.ajaxify')