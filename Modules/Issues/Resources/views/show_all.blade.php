<section class="panel panel-default">
    <header class="clearfix header">
        @if (isAdmin() || can('issues_create'))
        <a href="{{ route('issues.create', ['project' => $project->id, 'status' => get_option('default_issue_status')]) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
            @icon('regular/question-circle') @langapp('create')
        </a>
        <a href="{{ route('issues.sentry', $project->token) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
            @icon('brands/dev') Sentry
        </a>
        <a href="{{ route('issues.github', $project->token) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
            @icon('brands/github') Github Issues
        </a>
        @endif
    </header>

    <section class="overflow-x-auto bg-gray-200 wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body collapse in">
                        <div class="card-block">
                            <div class="">
                                <div class="lobilists-wrapper lobilists single-line sortable ps-container ps-theme-dark ps-active-x">

                                    @foreach(Modules\Issues\Entities\Issue::select('status')->distinct('status')->get() as $card)

                                    <div class="lobilist-wrapper ps-container ps-theme-dark ps-active-y kanban-col">
                                        <div id="lobilist-list-0" class="bg-white lobilist lobilist-info rounded-t-md">
                                            <div class="bg-gray-800 lobilist-header ui-sortable-handle rounded-t-md">
                                                <div class="lobilist-actions">
                                                    @if (isAdmin() || can('issues_create'))
                                                    <a href="{{route('issues.create', ['project' => $project->id, 'status' => $card->status])}}" data-toggle="ajaxModal"
                                                        class="btn {{themeButton()}}"">
                                                        @icon('solid/plus') @langapp('create')
                                                    </a>
                                                    @endif
                                                </div>
                                                <div class="font-semibold text-white uppercase  lobilist-title text-ellipsis">
                                                        {{ucfirst($card->AsStatus->status)}}
                                                </div>
                                            </div>
                                            <div class="lobilist-body scrumboard slim-scroll" data-height="450" data-disable-fade-out="true" data-distance="0" data-size="5px"
                                                data-color="#333333">
                                                <ul class="lobilist-items ui-sortable" id="{{$card->AsStatus->id}}">
                                                    @php $counter = 0; @endphp
                                                    @foreach ($project->issues->where('status', $card->AsStatus->id) as $issue)
                                                    <li id="{{$issue->id}}" draggable="true" class="lobilist-item kanban-entry grab">
                                                        <div class="lobilist-item-title text-ellipsis">
                                                            <a class="{{themeLinks('font-bold')}}"
                                                                href="{{ route('projects.view', ['project' => $issue->project_id, 'tab' => 'issues', 'item' => $issue->id]) }}">
                                                                {{ $issue->subject }}
                                                            </a>
                                                        </div>
                                                        <div class="text-gray-600 lobilist-item-description">
                                                            <span class="">{{$issue->user->name}}</span>
                                                            <span class="pull-right label label-warning">{{ $issue->priority }}</span>
                                                        </div>
                                                        <div class="text-xs text-gray-700 lobilist-item-duedate">
                                                            {{ dateFormatted($issue->created_at)}}
                                                        </div>
                                                        @if ($issue->user_id > 0)
                                                        <span class="thumb-xs avatar lobilist-check">
                                                            <img src="{{ $issue->user->profile->photo }}" class="img-circle" data-toggle="tooltip" title="{{$issue->user->name}}"
                                                                data-placement="right">
                                                        </span>
                                                        @endif

                                                        @if(isAdmin() || $issue->user_id)

                                                        <div class="todo-actions">
                                                            <a href="{{ route('issues.status', $issue->id) }}" data-toggle="ajaxModal">
                                                                @icon('solid/bars')
                                                            </a>
                                                            @can('issues_update')
                                                            <div class="ml-2 edit-todo todo-action">
                                                                <a href="{{ route('issues.edit', $issue->id) }}" data-toggle="ajaxModal">
                                                                    @icon('solid/edit')
                                                                </a>
                                                            </div>
                                                            @endcan

                                                        </div>

                                                        @endif

                                                        <div class="drag-handler"></div>
                                                    </li>
                                                    @php $counter++; @endphp
                                                    @endforeach

                                                </ul>
                                            </div>
                                            <div class="lobilist-footer">
                                                <strong>{{ $counter }} @langapp('issues') </strong>
                                                <strong class="pull-right"></strong>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog processing-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        @icon('solid/sync-alt', 'fa-4x fa-spin')
                                                        <h4>Processing...</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</section>
@push('pagescript')
<script type="text/javascript">
    $(document).ready(function () {
var kanbanCol = $('.scrumboard');
draggableInit();
});
function draggableInit() {
var sourceId;
$('[draggable=true]').bind('dragstart', function (event) {
sourceId = $(this).parent().attr('id');
event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
});
$('.scrumboard').bind('dragover', function (event) {
event.preventDefault();
});
$('.scrumboard').bind('drop', function (event) {
var children = $(this).children();
var targetId = children.attr('id');
if (sourceId != targetId) {
var elementId = event.originalEvent.dataTransfer.getData("text/plain");
$('#processing-modal').modal('toggle');
setTimeout(function () {
var element = document.getElementById(elementId);
issue_id = element.getAttribute('id');


axios.post('/api/v1/issues/'+issue_id+'/ajax-status', {
                'id': issue_id,
                'status': targetId
    })
            .then(function (response) {
                toastr.success(response.data, '@langapp('success') ');
    })
            .catch(function (error) {
                toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
    });

children.prepend(element);
$('#processing-modal').modal('toggle');
}, 1000);
}
event.preventDefault();
});
}
</script>
@endpush