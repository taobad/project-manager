<div class="w-full p-8 mt-6 leading-normal text-gray-900 bg-white border border-gray-200 lg:mt-0 border-rounded">
    <!--Title-->
    <div class="">
        <span class="{{themeText('font-semibold')}}">&laquo;</span>
        <a href="{{route('articles.public')}}" class="btn {{themebutton()}}">
            @langapp('articles')
        </a>
        <h1 class="pt-6 pb-2 text-2xl text-gray-800 break-normal">{{$article->subject}}</h1>
        <hr class="border-gray-400">
    </div>

    <div class="flex justify-between px-3 py-3 mt-6 text-sm text-gray-700 bg-gray-200 border-l-4 border-gray-700 rounded-sm">
        <div>By {{$article->user->name}} on {{$article->created_at->toDayDateTimeString()}}</div>
        <div>{{ $article->getRawOriginal('views') }} @langapp('views') </div>
    </div>
    <!--Post Content-->
    <!--Lead Para-->
    <div class="mt-6 prose-lg text-gray-700">
        {!!$article->description!!}
    </div>

    <!--/ Post Content-->
</div>
<!--Back link -->
<div class="w-full px-4 py-6 text-gray-500">
    <span class="{{themeText('font-semibold')}}">&laquo;</span>
    <a href="{{route('articles.public')}}" class="btn {{themeButton()}}">
        @langapp('articles')
    </a>
</div>