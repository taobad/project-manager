<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-danger">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/trash-alt') @langapp('delete')  </h4>
        </div>

        {!! Form::open(['route' => ['links.destroy', $link->id], 'method' => 'DELETE']) !!}

        <div class="modal-body">
            <p>@langapp('delete_warning')  </p>

            <a href="{{ $link->url }}" target="_blank">{{ $link->title }}</a>

            <input type="hidden" name="id" value="{{  $link->id  }}">
            <input type="hidden" name="url" value="{{ route('projects.view', ['project' => $link->project->id, 'tab' => 'links']) }}">

        </div>
        <div class="modal-footer">
            
            {!! closeModalButton() !!}
            {!! okModalButton() !!}
            
        </div>


        {!! Form::close() !!}
    </div>
</div>