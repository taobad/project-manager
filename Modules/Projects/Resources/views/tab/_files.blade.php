@if(($project->setting('show_project_files') && $project->isClient()) || isAdmin() || $project->isTeam())
<section class="scrollable">


    <header class="clearfix header">
        <div class="row m-t-sm">
            <div class="col-sm-12 m-b-xs">

                <a href="{{route('files.upload', ['module' => 'projects', 'id' => $project->id])}}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                    @icon('solid/cloud-upload-alt') @langapp('upload_file')
                </a>


            </div>
        </div>
    </header>

    @include('partial._show_files', ['files' => $project->files])










</section>

@if (settingEnabled('filestack_active'))
@push('pagescript')
<script src="https://static.filestackapi.com/v3/filestack.js"></script>
@endpush
@endif

@endif