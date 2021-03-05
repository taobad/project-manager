@if(($project->setting('show_project_links') && $project->isClient()) || isAdmin() || $project->isTeam())
<section class="scrollable">
    @if(is_null($item))
    <section class="panel panel-default">
        <header class="clearfix bg-white header b-b">
            <div class="row m-t-sm">
                <div class="col-sm-12 m-b-xs">
                    @if(isAdmin() || can('links_create'))
                    <a href="{{ route('links.create', ['project' => $project->id]) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                        @icon('solid/globe') @langapp('create')</a>
                    @endif
                </div>
            </div>
        </header>
        <div class="panel-body">
            <ul class="media-list links-media">

                @foreach ($project->links as $key => $link)
                <li class="media">
                    <div class="media-left">
                        <a href="#" class="btn border-primary text-primary btn-flat btn-icon btn-rounded btn-sm">
                            <img class="favicon no-margin" src="http://www.google.com/s2/favicons?domain={{ $link->url }}" />
                        </a>
                    </div>
                    <div class="media-body">
                        <a href="{{ route('projects.view', ['project' => $link->project_id, 'tab' => 'links', 'item' => $link->id]) }}">{{ $link->title }}
                            @if (!empty($link->password))
                            @icon('solid/lock')
                            @endif
                        </a>
                        <span class="pull-right">
                            <a href="{{ route('links.edit', $link->id) }}" class="btn btn-xs btn-default" data-toggle="ajaxModal">@langapp('edit')</a>
                            <a href="{{ route('links.pin', $link->id) }}" title="@langapp('link_pin') "
                                class="btn btn-xs {{ $project->client_id === $link->client_id ? 'btn-danger' : 'btn-default' }}">
                                Pin
                            </a>
                            @if(isAdmin() || $link->user_id == Auth::id())
                            <a href="{{ route('links.delete', $link->id) }}" data-toggle="ajaxModal" title="@langapp('delete')" class="btn btn-xs btn-default">
                                @langapp('delete')
                            </a>
                            @endif

                        </span>

                        @parsedown($link->description)

                        <div class="media-annotation">
                            {{ $link->created_at ? dateElapsed($link->created_at) : '' }}
                        </div>
                    </div>
                </li>

                @endforeach
            </ul>
        </div>
    </section>
    @else
    <section class="panel panel-default">
        @php $link = Modules\Projects\Entities\Link::findOrFail($item); @endphp
        @if ($link->project_id == $project->id)
        <header class="clearfix bg-white header b-b">
            <div class="row m-t-sm">
                <div class="col-sm-12 m-b-xs">
                    <a class="btn {{themeButton()}}" href="{{ route('projects.view', ['id' => $project->id, 'tab' => 'links'])  }}">
                        @icon('solid/caret-left') @langapp('links')
                    </a>

                    @if(isAdmin() || $project->isTeam())
                    <a href="{{ route('links.edit', $link->id) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">@langapp('edit') </a>
                    <a href="{{ route('links.delete', $link->id) }}" data-toggle="ajaxModal" title="@langapp('delete')" class="btn {{themeButton()}}">
                        @icon('solid/trash-alt') @langapp('delete')
                    </a>
                    @endif
                </div>
            </div>
        </header>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-7">
                    <ul class="list-group no-radius">
                        <li class="list-group-item">
                            <span class="pull-right">{{ $link->title }} </span>@langapp('link_title')
                        </li>
                        <li class="list-group-item">
                            <span class="pull-right"><a href="{{ $link->url }}" target="_blank">{{ $link->url }} </a>
                            </span>@langapp('link_url')
                        </li>
                        <li class="list-group-item">
                            <span class="pull-right">{{ $link->project->name  }}</span>
                            @langapp('project')
                        </li>
                    </ul>
                </div>
                <div class="col-lg-5">
                    <ul class="list-group no-radius">
                        <li class="list-group-item">
                            <span class="pull-right">{{ $link->username }}</span>@langapp('username')
                        </li>
                        <li class="list-group-item">
                            <span class="pull-right">
                                {{ $link->password }}
                            </span>@langapp('password')
                        </li>
                    </ul>
                </div>
            </div>
            <p>
                <blockquote class="small text-muted">@parsedown($link->description)</blockquote>
            </p>
        </div>
        @endif
    </section>
    @endif


</section>
@endif