@extends('layouts.app')
@section('content')
@php $categories = App\Entities\Category::with('articles')->where('module','knowledgebase')->get(); @endphp
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">

                        <div>
                            @can('articles_create')
                            @can('settings')
                            <a href="{{ route('kb.category.show') }}" class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip" title="@langapp('category')"
                                data-placement="bottom">
                                @icon('solid/layer-group')
                            </a>
                            @endcan


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
                    <section class="panel panel-default">

                        <div class="p-6 leading-10 text-center">
                            <div class="{{themeText()}} text-3xl">@langapp('knowledgebase')</div>
                            <div>
                                <p class="text-lg">
                                    Get answers and help from our knowledgebase You can also <a href="{{route('tickets.create')}}" class="{{themeLinks()}}">open a support
                                        ticket</a>
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 panel-body">

                            @foreach ($categories->chunk(3) as $chunk)
                            <div class="p-2 row">
                                @foreach ($chunk as $group)

                                <div class="col-md-4">

                                    <div class="max-w-md px-8 py-4 my-8 bg-gray-100 rounded-lg shadow-lg">
                                        <div class="flex justify-center -mt-16 md:justify-end">
                                            @icon('solid/'.$group->icon,'object-cover w-16 h-16 text-gray-500 p-2 border-2 border-gray-500 bg-gray-100 rounded-full')
                                        </div>
                                        <div>
                                            <h2 class="text-3xl font-semibold text-gray-600">{{str_limit($group->name,20)}}</h2>
                                            <p class="mt-2 text-gray-600">{{$group->description}}</p>
                                        </div>
                                        @if (count($group->articles))
                                        <div class="flex justify-end mt-4">
                                            <a href="{{route('kb.articles',$group->id)}}" class="{{themeButton()}}">See all articles ({{ count($group->articles) }})</a>
                                        </div>
                                        @endif

                                    </div>

                                </div>

                                @endforeach
                            </div>
                            @endforeach

                        </div>

                    </section>
                </section>
            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>

@push('pagestyle')
<link rel="stylesheet" href="{{ getAsset('plugins/iconpicker/fontawesome-iconpicker.min.css') }}" type="text/css" />
@endpush

@endsection