@extends('layouts.app')
@section('content')

<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">

                        <a href="{{ route('kb.index') }}" class="btn {{themeButton()}}">
                            @icon('solid/lightbulb') @langapp('knowledgebase')
                        </a>

                        <div>
                            <span class="text-lg"><i class="fas fa-{{$group->icon}}"></i> {{$group->name}}</span>
                        </div>

                        <div>
                            @can('articles_create')
                            <a href="{{route('kb.create')}}" class="btn {{themeButton()}}">
                                @icon('solid/plus') @langapp('create')
                            </a>
                            @endcan
                            @if (settingEnabled('public_knowledgebase') || isAdmin())
                            <a href="{{route('articles.public')}}" class="btn {{themeButton()}}" target="_blank">
                                @icon('solid/book-reader') @langapp('public')
                            </a>
                            @endif
                        </div>
                    </div>
                </header>
                <section class="bg-indigo-100 scrollable wrapper">

                    @livewire('knowledgebase.articles', ['group_id' => $group_id])


                </section>
            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>

@endsection