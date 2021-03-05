<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/comments', 'fa-1x') @langapp('comments') </h4>
        </div>
        <div class="modal-body">
            <div class="">
                <section class="block comment-list ">


                    <article class="comment-item" id="comment-form">
                        <a class="pull-left thumb-sm avatar">
                            <img src="{{ avatar() }}" class="img-circle">
                        </a>
                        <span class="arrow left"></span>
                        <section class="comment-body">
                            <section class="p-2 panel panel-default">

                                @widget('Comments\CreateWidget', ['commentable_type' => 'credits' , 'commentable_id' => $creditnote->id])


                            </section>
                        </section>
                    </article>
                    @widget('Comments\ShowComments', ['comments' => $creditnote->comments])
                </section>
            </div>

        </div>
    </div>
</div>
@push('pagescript')
@include('comments::_ajax.ajaxify')
@endpush

@stack('pagescript')