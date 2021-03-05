@extends('layouts.app')
@section('content')

<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">
                        <div>
                            <a href="{{route('kb.index')}}" class="btn {{themeButton()}}">
                                @icon('solid/chevron-left') @langapp('knowledgebase')
                            </a>
                            @if (can('articles_create') || $article->user_id == Auth::id())
                            <a href="{{route('kb.edit', $article->id) }}" class="btn {{themeButton()}}">@icon('solid/pencil-alt') @langapp('edit')
                            </a>
                            @endif
                        </div>
                        <div>
                            @if (can('articles_delete') || $article->user_id == Auth::id())
                            <a href="{{route('kb.delete', $article->id) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                                @icon('solid/trash-alt')
                            </a>
                            @endif
                        </div>
                    </div>
                </header>
                <section class="bg-gray-100 scrollable wrapper with-responsive-img kb-pad">
                    <div class="col-md-8">
                        <div class="content-group-lg">
                            <h3 class="py-2 mb-2 text-2xl font-semibold text-gray-600">{{ $article->subject }}</h3>
                            @if($article->active == 0)
                            <div class="alert alert-warning alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <p>@icon('solid/exclamation-circle') This article is not published yet</p>
                            </div>
                            @endif
                            <ul class="text-sm text-gray-600 list-inline list-inline-separate content-group">
                                <li>
                                    By <a href="#" class="{{themeLinks('font-semibold')}}">
                                        {{ $article->user->name }}
                                    </a>
                                </li>
                                <li>
                                    @icon('regular/clock',themeText()) {{ dateTimeFormatted($article->created_at) }}
                                </li>
                                @if ($article->allow_comments)
                                <li>
                                    <a href="#comments" data-toggle="tooltip" title="@langapp('comments')">
                                        @icon('solid/comments',themeText()) {{ $article->comments_count }} @langapp('comments')
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="#" data-toggle="tooltip" title="@langapp('views')">
                                        @icon('solid/eye',themeText()) {{ $article->views }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" data-toggle="tooltip" title="@langapp('reviews')">
                                        @icon('solid/star',themeText()) {{ $article->rating }}%
                                    </a>
                                </li>
                            </ul>
                            <div class="mt-2 text-sm prose-lg text-gray-700">
                                {!!parsedown($article->description)!!}
                            </div>

                            <div class="m-sm">
                                <div class="flex justify-between text-gray-500">
                                    <div>
                                        <a href="{{ route('kb.vote', ['kb' => $article->id, 'vote' => 1]) }}" class="btn {{themeButton()}}">
                                            @icon('solid/thumbs-up') +1 @langapp('helpful')
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{ route('kb.vote', ['kb' => $article->id, 'vote' => 0]) }}" class="btn {{themeButton()}}">
                                            @icon('solid/thumbs-down') -1 @langapp('not_helpful')
                                        </a>
                                    </div>
                                </div>
                            </div>


                        </div>
                        @if ($article->allow_comments)
                        <div class="panel-heading">
                            <h3 class="panel-title" id="comments">@langapp('comments') </h3>
                        </div>
                        <div class="m-xs">

                            <section class="block comment-list">
                                <article class="comment-item" id="comment-form">
                                    <a class="pull-left thumb-sm avatar">
                                        <img src="{{ avatar() }}" class="img-circle">
                                    </a>
                                    <span class="arrow left"></span>
                                    <section class="comment-body">
                                        <section class="p-2 panel panel-default">
                                            @widget('Comments\CreateWidget', ['commentable_type' => 'knowledgebase', 'commentable_id' => $article->id, 'hasFiles' => true])
                                        </section>
                                    </section>
                                </article>

                                @widget('Comments\ShowComments', ['comments' => $article->comments, 'withReplies' => true])
                            </section>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <section class="mb-2 bg-white rounded-sm">
                            <header class="p-2 text-white uppercase bg-indigo-500 rounded-t-sm">
                                @langapp('related_articles')
                            </header>
                            <ul class="">
                                @foreach(Modules\Knowledgebase\Entities\Knowledgebase::whereGroup($article->group)->orderByDesc('id')->get() as $related)
                                <li class="p-3 border-b">
                                    <div class="media">
                                        <div class="media-body">
                                            <div>
                                                <a href="{{ route('kb.view', $related->id) }}" class="{{themeLinks('font-semibold')}}">
                                                    {{ str_limit($related->subject,20) }}
                                                </a>
                                                <p>@parsedown(str_limit(strip_tags($related->description), 50))</p>
                                                <div class="p-1 text-xs text-gray-600">@langapp('created_at'):
                                                    {{ dateTimeString($related->created_at) }} </div>
                                            </div>
                                            <div class="flex justify-between text-gray-500">
                                                <span data-toggle="tooltip" title="@langapp('views')">
                                                    @icon('solid/desktop')
                                                    {{ $related->views }}
                                                </span>
                                                <span data-toggle="tooltip" title="@langapp('comments')">
                                                    @icon('regular/comments')
                                                    {{ $related->comments_count }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </section>
                    </div>
                </section>
            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@push('pagestyle')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.wysiwyg')
@include('comments::_ajax.ajaxify')
@endpush
@endsection