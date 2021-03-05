<nav id="header" class="fixed top-0 z-10 w-full bg-white border-b border-gray-300">
    <div class="container flex flex-wrap items-center justify-between w-full py-4 mx-auto mt-0">
        <div class="flex items-center pl-4">
            @icon('solid/book',themeText('h-5 pr-3 fill-current'))
            <a href="{{url('/articles')}}" class="text-xl font-bold {{themeText()}} no-underline hover:no-underline">
                {{get_option('company_name')}}
            </a>
        </div>
        <div class="block pr-4 lg:hidden">
            <button id="nav-toggle"
                class="flex items-center px-3 py-2 text-gray-500 border border-gray-600 rounded appearance-none hover:text-gray-900 hover:border-purple-500 focus:outline-none">
                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
            </button>
        </div>
        <div class="z-20 flex-grow hidden w-full mt-2 lg:flex lg:content-center lg:items-center lg:w-auto lg:block lg:mt-0" id="nav-content">
            @livewire('article.search')

            <ul class="flex items-center justify-between px-3">
                <li class="py-2 mr-3 lg:py-0">
                    <a class="inline-block {{themeButton()}}" href="{{url('/login')}}">@langapp('dashboard')</a>
                </li>
                <li class="py-2 mr-3 lg:py-0">
                    <a href="mailto:{{get_option('company_email')}}" class="inline-block {{themeButton()}}">
                        Contact Us
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>