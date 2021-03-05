<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('remove_member') </h4>
        </div>

        {!! Form::open(['route' => 'teams.detach', 'class' => 'bs-example form-horizontal ajaxifyForm']) !!}

        <input type="hidden" name="project_id" value="{{  $project  }}">
        <input type="hidden" name="member_id" value="{{  $member  }}">

        <div class="modal-body prose-lg text-sm">
            <p>Member <strong
                    class="text-indigo-600">{{ Modules\Users\Entities\User::findOrFail($member)->name }}</strong> will
                be removed from
                project <strong
                    class="text-indigo-600">{{  Modules\Projects\Entities\Project::findOrFail($project)->name  }}</strong>
            </p>


        </div>
        <div class="modal-footer">

            {!! closeModalButton() !!}
            {!! renderAjaxButton() !!}

        </div>
        {!! Form::close() !!}
    </div>
</div>

@include('partial.ajaxify')