@if (isAdmin() || can('projects_view_notes'))

{!! Form::open(['route' => 'notes.project', 'class' => 'ajaxifyForm']) !!}

<input type="hidden" name="project_id" value="{{  $project->id  }}">
<div>
    <x-inputs.wysiwyg name="notes" class="{{ get_option('htmleditor') }}" id="project-notes">
        {!!$project->notes!!}
    </x-inputs.wysiwyg>
</div>

<hr>
<div class="m-xs">
    {!! renderAjaxButton() !!}
</div>
{!! Form::close() !!}


@push('pagestyle')
@include('stacks.css.wysiwyg')
@endpush

@push('pagescript')
@include('stacks.js.wysiwyg')
@endpush

@endif