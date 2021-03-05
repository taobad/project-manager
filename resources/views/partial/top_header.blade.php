<header class="bg-{{ get_option('top_bar_color') }} header navbar navbar-fixed-top-xs nav-z">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">
                @icon('solid/bars')
            </a>
            <a href="{{url('/')}}" class="navbar-brand {{themeText()}}">
                @php $display = get_option('logo_or_icon'); @endphp
                @if ($display == 'logo' || $display == 'logo_title')
                <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('company_logo'))}}" class="mr-1">
                @elseif ($display == 'icon' || $display == 'icon_title')
                <i class="fa {{get_option('site_icon')}}"></i>
                @endif
                @if ($display == 'logo_title' || $display == 'icon_title')
                @if (get_option('website_name') == '')
                {{ get_option('company_name') }}
                @else
                {{ get_option('website_name') }}
                @endif
                @endif
            </a>
            <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
                @icon('solid/cog')
            </a>
        </div>
        <ul class="nav navbar-nav hidden-xs" id="todolist">
            <li class="">

                <div class="m-t m-l-lg">
                    @if (\Auth::user()->tasksUpcoming() > 0)
                    <a href="{{ route('tasks.upcoming') }}" class="" data-toggle="tooltip" title="@langapp('tasks')" data-placement="bottom">
                        @icon('solid/tasks')
                        <span class="bg-red-500 badge badge-sm up m-l-n-sm display-inline">{{ \Auth::user()->tasksUpcoming() }}</span>
                    </a>
                    @endif
                    @if (\Auth::user()->todoToday() > 0)
                    <a href="{{ route('calendar.todos') }}" class="" data-toggle="tooltip" title="@langapp('todo')" data-placement="bottom">
                        @icon('regular/check-circle')
                        <span class="bg-red-500 badge badge-sm up m-l-n-sm display-inline">{{ \Auth::user()->todoToday() }}</span>
                    </a>
                    @endif

                    @if(Auth::user()->newchats->count())
                    <a href="{{ route('leads.index') }}" class="m-l" data-toggle="tooltip" title="WhatsApp" data-placement="bottom">
                        @icon('solid/comment-alt', 'fa-lg text-success')
                        <span class="badge badge-sm up bg-dracula m-l-n-sm display-inline">{{ Auth::user()->newchats->count() }}</span>
                    </a>
                    @endif

                    @modactive('calendar')

                    <a href="{{ route('calendar.appointments') }}" class="m-l" data-toggle="tooltip" title="@langapp('appointments') " data-placement="bottom">
                        @icon('solid/calendar-check')
                    </a>

                    @endmod

                </div>

            </li>
        </ul>


        <ul class="nav navbar-nav navbar-right hidden-xs nav-user">

            @if(count(runningTimers()) > 0)
            <li class="">
                <a href="{{ route('timetracking.timers') }}" title="@langapp('timers')" data-toggle="ajaxModal" data-toggle="tooltip" data-placement="bottom">
                    <i class="fas fa-sync-alt fa-spin fa-lg {{themeText()}}"></i>
                    <span class="bg-blue-400 badge badge-sm up m-l-n-sm display-inline">{{ count(runningTimers()) }}</span>
                </a>
            </li>
            @endif

            @include('partial.notifications')

            @admin
            <li class="dropdown hidden-xs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" x-on:click="$refs.searchField.focus()">
                    @icon('solid/search', 'fa-fw')
                </a>
                <section class="dropdown-menu aside-xl animated fadeInUp">
                    <section class="bg-white panel">

                        <form action="{{ route('search.app') }}" method="POST" role="search">
                            {!! csrf_field() !!}
                            <div class="flex w-full p-4 md:ml-0">
                                <label for="search_field" class="sr-only">Search</label>
                                <div class="relative w-full text-gray-500 focus-within:text-gray-600">
                                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 m-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"></path>
                                        </svg>
                                    </div>
                                    <input x-ref="searchField" x-on:keydown.window.prevent.slash="$refs.searchField.focus()" name="keyword" placeholder="Type and press Enter"
                                        class="block w-full h-full py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 bg-gray-200 rounded-md focus:outline-none focus:placeholder-gray-600 sm:text-sm">
                                </div>
                            </div>


                        </form>
                    </section>
                </section>
            </li>
            @endadmin

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="thumb-sm avatar pull-left">
                        <img src="{{ avatar() }}" class="img-circle">
                    </span>
                    {{ Auth::user()->name }} <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInRight">
                    <li class="arrow top"></li>
                    <li><a href="{{ route('users.profile') }}">@langapp('settings') </a></li>
                    <li><a href="{{ route('users.reminders') }}">@langapp('reminders')</a></li>
                    <li><a href="{{ route('users.notifications') }}">@langapp('notifications') </a></li>
                    <li><a href="{{ route('extras.user.templates') }}">@langapp('canned_responses')</a></li>
                    @if(config('system.remote_support') && isAdmin())
                    <li><a href="{{ route('support.ticket') }}" data-toggle="ajaxModal">Need Help?</a></li>
                    <li><a href="{{ route('tell.friend') }}" data-toggle="ajaxModal">@langapp('tell_friend')</a></li>
                    @endif
                    <li class="divider"></li>
                    @if(Auth::user()->isImpersonating())
                    <li><a href="{{ route('users.stopimpersonate') }}">@langapp('stop_impersonate')</a></li>
                    @endif
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            @icon('solid/sign-out-alt') Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</header>