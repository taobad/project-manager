<footer class="bg-white border-t border-gray-200 shadow">
    <div class="container flex py-8 mx-auto">
        <div class="flex flex-wrap w-full mx-auto">
            <div class="flex w-full lg:w-1/2 ">
                <div class="px-8">
                    <h3 class="font-bold text-gray-900">About</h3>
                    <p class="py-2 text-sm text-gray-600">
                        @php
                        $data['company'] = (object)['locale' => 'en'];
                        @endphp
                        <address>
                            {!! formatCompanyAddress($data) !!}
                        </address>
                    </p>
                </div>
            </div>
            <div class="flex w-full lg:w-1/2 lg:justify-end lg:text-right">
                <div class="px-8">
                    <h3 class="font-bold text-gray-900">@langapp('links')</h3>
                    <ul class="items-center pt-3 text-sm list-reset">
                        <li>
                            <a href="{{get_option('company_domain')}}" target="_blank" class="inline-block py-1 {{themeLinks()}}">@langapp('website')</a>
                        </li>
                        <li>
                            <a href="{{get_option('privacy_policy_url')}}" target="_blank" class="inline-block py-1 {{themeLinks()}}">@langapp('privacy_policy')</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>