<section class="panel panel-default">
    <header class="clearfix bg-white header b-b">
        <div class="row m-t-sm">
            <div class="col-sm-12 m-b-xs">
                @if(can('files_create') || isAdmin())
                <a href="{{route('files.upload', ['module' => 'issues', 'id' => $issue->id])}}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                    @icon('solid/cloud-upload-alt') @langapp('upload_file')
                </a>
                @endif
                @if (isAdmin() || $project->isTeam() || $issue->user_id === Auth::id())
                <a href="{{route('issues.edit', $issue->id)}}" data-toggle="ajaxModal" class="btn {{themeButton()}}">@icon('solid/pencil-alt')
                    @langapp('edit')
                </a>
                <a href="{{route('issues.delete', $issue->id)}}" data-toggle="ajaxModal" class="pull-right btn {{themeButton()}}">@icon('solid/trash-alt')
                    @langapp('delete')
                </a>
                @endif

            </div>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <aside class="col-lg-4 lg:border-r lg:border-gray-200">
                        <section class="scrollable">

                            <div class="clearfix m-b">
                                @if($issue->assignee > 0)
                                <a href="#" class="pull-left thumb m-r">
                                    <img src="{{ optional($issue->agent)->profile->photo}}" class="img-circle" data-toggle="tooltip" data-title="{{optional($issue->agent)->name}}"
                                        data-placement="bottom">
                                </a>
                                @endif
                                <div class="clear">
                                    <div class="my-1 text-xl break-words">{{ $issue->subject }}</div>
                                    <div class="text-muted">@icon('regular/user-circle') {{ optional($issue->agent)->name }}</div>
                                </div>
                            </div>
                            <div class="panel wrapper panel-success">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <span class="block text-gray-500 uppercase m-b-xs">@langapp('severity')</span>
                                        <div class="font-semibold text-gray-600">{{$issue->severity}}</div>
                                    </div>
                                    <div class="col-xs-6">
                                        <span class="block text-gray-500 uppercase m-b-xs">@langapp('status')</span>
                                        <div class="font-semibold text-gray-600">@langapp(strtolower($issue->AsStatus->status))</div>
                                    </div>
                                </div>
                            </div>

                            <div>

                                <div>
                                    <div class="text-gray-500 uppercase">@langapp('reporter')</div>
                                    <div class="py-2">
                                        <span class="font-semibold text-indigo-600">
                                            {{ $issue->user->name }}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <div class="text-gray-500 uppercase">@langapp('date')</div>
                                    <div class="py-2">
                                        <span class="font-semibold text-gray-600">
                                            {{ $issue->created_at->toDayDateTimeString() }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-gray-500 uppercase">@langapp('priority')</div>
                                    <div class="py-2">
                                        <span class="font-semibold text-gray-600">
                                            @langapp(strtolower($issue->priority))
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <div class="text-gray-500 uppercase">@langapp('description')</div>
                                    <div class="py-2">
                                        <span class="text-gray-600 break-words">
                                            @parsedown($issue->description)
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <div class="text-gray-500 uppercase">@langapp('reproducibility')</div>
                                    <div class="py-2">
                                        <span class="text-gray-600 break-words">
                                            @parsedown($issue->reproducibility)
                                        </span>
                                    </div>
                                </div>

                                <div class="m-xs"></div>

                                <small class="text-uc text-muted">
                                    @icon('solid/shield-alt')
                                    @langapp('vaults')
                                    <a href="{{ route('extras.vaults.create', ['module' => 'issues', 'id' => $issue->id]) }}" class="btn btn-xs btn-danger pull-right"
                                        data-toggle="ajaxModal">@icon('solid/plus')</a>
                                </small>
                                <div class="line"></div>
                                @widget('Vaults\Show', ['vaults' => $issue->vault])
                                @admin

                                <small class="text-uc text-muted">@icon('solid/tags') @langapp('tags')</small>
                                <div class="line"></div>

                                @php
                                $data['tags'] = $issue->tags;
                                @endphp
                                @include('partial.tags', $data)

                                @if (count((array)$issue->meta))
                                <small class="text-xs text-gray-600 uppercase">Metadata</small>
                                <div class="line"></div>
                                @foreach ($issue->meta as $key => $meta)
                                <div class="py-1 text-gray-600 uppercase">{{ $key }}</div>
                                @if (!is_array($meta))
                                <div class="font-semibold text-gray-600">
                                    {{ $meta }}
                                </div>
                                @else
                                @foreach ($meta as $value)
                                <div class="py-1 text-gray-600 uppercase">{{$value[0]}}</div>
                                <div class="font-semibold text-gray-700 break-words">{{$value[1]}}</div>
                                @endforeach
                                @endif

                                @endforeach
                                @endif



                                @endadmin

                            </div>


                        </section>
                    </aside>
                    <aside class="col-lg-8">



                        <div id="tabs">
                            <ul class="nav nav-tabs" id="prodTabs">
                                <li class="active"><a href="#tab_comments">@langapp('comments')</a></li>
                                <li><a href="#tab_files" data-url="/issues/ajax/files/{{ $issue->id }}">@langapp('files')</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab_comments" class="tab-pane active">
                                    <section class="block comment-list">
                                        <article class="comment-item" id="comment-form">
                                            <a class="pull-left thumb-sm avatar">
                                                <img src="{{ avatar() }}" class="img-circle">
                                            </a>
                                            <span class="arrow left"></span>
                                            <section class="comment-body">
                                                <section class="p-2 panel panel-default">
                                                    @widget('Comments\CreateWidget', ['commentable_type' => 'issues' , 'commentable_id' => $issue->id, 'hasFiles' => true])
                                                </section>
                                            </section>
                                        </article>

                                        @widget('Comments\ShowComments', ['comments' => $issue->comments])

                                    </section>
                                </div>
                                <div id="tab_files" class="tab-pane active"></div>
                            </div>
                        </div>



                    </aside>
                </div>
            </section>
        </div>

    </div>
</section>

@push('pagestyle')
@include('stacks.css.wysiwyg')
@endpush

@push('pagescript')
@include('stacks.js.wysiwyg')
@include('comments::_ajax.ajaxify')

<script>
    $('#tabs').on('click','.tablink,#prodTabs a',function (e) {
        e.preventDefault();
        var url = $(this).attr("data-url");
        if (typeof url !== "undefined") {
            var pane = $(this), href = this.hash;
            $(href).load(url,function(result){      
                pane.tab('show');
            });
        } else {
            $(this).tab('show');
        }
    });
</script>

@endpush