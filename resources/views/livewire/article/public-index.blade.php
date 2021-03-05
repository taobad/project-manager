<div class="px-4 py-6 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">

    @if ($articles->count())

    <div class="mb-10 border-t border-b">

        @foreach ($articles as $article)
        <div class="grid py-8 sm:grid-cols-4">
            <div class="mb-4 sm:mb-0">
                <div class="font-sans text-xs font-semibold tracking-wide uppercase">
                    <a href="?cat={{$article->group}}" class="{{themeLinks()}}" aria-label="Category">
                        {{$article->category->name}}
                    </a>
                    <p class="text-gray-600">{{$article->created_at->diffForHumans()}}</p>
                </div>
            </div>
            <div class="sm:col-span-3">
                <div class="mb-3">
                    <a href="{{route('articles.public.view',$article->id)}}" aria-label="Article" class="inline-block {{themeLinks()}}">
                        <p class="font-sans text-3xl font-bold leading-none sm:text-4xl xl:text-4xl">
                            {{str_limit($article->subject,30)}}
                        </p>
                    </a>
                </div>
                <p class="font-sans text-gray-700">
                    {{str_limit(strip_tags($article->description),250)}}
                </p>
            </div>
        </div>
        @endforeach

    </div>
    <div class="text-center">
        {{$articles->links()}}
    </div>
    @else
    <div>
        <p class="text-base text-gray-600">
            No articles found!
        </p>
    </div>
    @endif
</div>