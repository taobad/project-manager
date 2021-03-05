@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">
                        <div>
                            <span class="text-xl font-semibold text-gray-600">@langapp('notifications')</span>
                        </div>
                        <div>
                            @admin
                            <a href="{{ route('notifications.preferences') }}" class="btn {{themeButton()}}">
                                @icon('solid/cogs') @langapp('notifications')
                            </a>
                            @endadmin
                        </div>
                    </div>
                </header>

                <section class="scrollable wrapper bg">

                    @livewire('latest-notifications')

                </section>
            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@endsection