@if(($project->setting('show_project_comments') && $project->isClient()) || isAdmin() || $project->isTeam())
<div class="row">
    <div class="col-lg-12">
        <section class="panel panel-body">

            <div class="">

                <section class="block comment-list">
                    <article class="comment-item" id="comment-form">
                        <a class="pull-left thumb-sm avatar">
                            <img src="{{ avatar() }}" class="img-circle">
                        </a>
                        <span class="arrow left"></span>
                        <section class="comment-body">
                            <section class="p-2 panel panel-default">
                                @widget('Comments\CreateWidget', ['commentable_type' => 'projects' , 'commentable_id' => $project->id, 'hasFiles' => true])


                            </section>
                        </section>
                    </article>
                    @widget('Comments\ShowComments', ['comments' => $project->comments, 'withReplies' => true])

                </section>

            </div>
        </section>
    </div>
</div>

@push('pagestyle')
@include('stacks.css.wysiwyg')
@endpush

@push('pagescript')
@include('stacks.js.wysiwyg')
@include('comments::_ajax.ajaxify')
@endpush
@endif