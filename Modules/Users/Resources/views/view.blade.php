@extends('layouts.app')

@section('content')
<section id="content">
    <section class="hbox stretch">
        <section class="vbox">
            <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                <div class="flex justify-between text-gray-500">
                    <div>
                        @can('menu_users')
                        <a href="{{ route('users.index') }}" data-toggle="tooltip" data-placement="bottom" class="btn {{themeButton()}}" title="Back">
                            @icon('solid/chevron-left')
                        </a>
                        @can('users_update')
                        <a href="{{ route('users.edit', $user->id) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                            @icon('solid/pencil-alt') @langapp('edit')
                        </a>

                        <a href="{{ route('users.permissions', $user->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                            @icon('solid/shield-alt') @langapp('permission')
                        </a>
                        @endcan
                        @endcan
                    </div>
                    <div>
                        @if ($user->id != Auth::id())
                        @can('users_delete')
                        <a href="{{ route('users.suspend', $user->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip" title="@langapp('suspend')"
                            data-placement="bottom">
                            @icon('solid/ban') @langapp('suspend')
                        </a>

                        <a href="{{ route('users.delete', $user->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip" data-placement="bottom"
                            title="@langapp('delete')">
                            @icon('solid/trash-alt')
                        </a>
                        @endcan
                        @endif
                    </div>
                </div>
            </header>

            <section class="scrollable wrapper bg">

                @if($user->banned)
                <x-alert type="danger" icon="solid/ban" class="text-sm leading-5">
                    Account suspended: {{$user->ban_reason}}
                </x-alert>
                @endif


                <div class="sub-tab text-uc small m-b-sm">

                    <ul class="nav pro-nav-tabs nav-tabs-dashed">
                        <li class="{{ ($tab == 'overview') ? 'active' : '' }}">
                            <a href="{{ route('users.view', ['user' => $user->id, 'tab' => 'overview']) }}">
                                @icon('solid/database') @langapp('overview')
                            </a>
                        </li>

                        <li class="{{ ($tab == 'files') ? 'active' : '' }}">
                            <a href="{{ route('users.view', ['user' => $user->id, 'tab' => 'files']) }}">
                                @icon('solid/folder-open') @langapp('files')
                            </a>
                        </li>
                        <li class="{{ ($tab == 'tickets') ? 'active' : '' }}">
                            <a href="{{ route('users.view', ['user' => $user->id, 'tab' => 'tickets']) }}">
                                @icon('solid/life-ring') @langapp('tickets')
                            </a>
                        </li>
                        <li class="{{ ($tab == 'projects') ? 'active' : '' }}">
                            <a href="{{ route('users.view', ['user' => $user->id, 'tab' => 'projects']) }}">
                                @icon('solid/clock') @langapp('projects')
                            </a>
                        </li>


                        <li class="{{ ($tab == 'timesheet') ? 'active' : '' }}">
                            <a href="{{ route('users.view', ['user' => $user->id, 'tab' => 'timesheet']) }}">
                                @icon('solid/history') @langapp('timesheets')
                            </a>
                        </li>


                        <li class="{{ ($tab == 'deals') ? 'active' : '' }}">
                            <a href="{{ route('users.view', ['user' => $user->id, 'tab' => 'deals']) }}">
                                @icon('solid/euro-sign') @langapp('deals')
                            </a>
                        </li>

                        <li class="{{ ($tab == 'calls') ? 'active' : '' }}">
                            <a href="{{ route('users.view', ['user' => $user->id, 'tab' => 'calls']) }}">
                                @icon('solid/phone') @langapp('calls')
                            </a>
                        </li>

                        <li class="{{ ($tab == 'whatsapp') ? 'active' : '' }}">
                            <a href="{{ route('users.view', ['user' => $user->id, 'tab' => 'whatsapp']) }}">
                                @icon('brands/whatsapp','text-success') WhatsApp
                            </a>
                        </li>

                        <li class="{{  ($tab == 'sms') ? 'active' : ''  }}">
                            <a href="{{  route('users.view', ['user' => $user->id, 'tab' => 'sms'])  }}">
                                @icon('solid/sms') SMS
                            </a>
                        </li>


                    </ul>

                </div>



                @include('users::tab.'.$tab)




            </section>


        </section>


    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>
@push('pagestyle')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.wysiwyg')
@endpush


@endsection