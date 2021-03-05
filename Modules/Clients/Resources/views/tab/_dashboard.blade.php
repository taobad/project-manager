<div class="p-3 m-1">
    <div class="grid grid-cols-1 mt-2 overflow-hidden bg-white rounded-lg shadow md:grid-cols-3">
        <div>
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('creditnotes')">
                        @langapp('credits')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{formatCurrency($company->currency, $company->creditBalance())}}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                {{ get_option('default_currency') }}
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-orange-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-file-invoice"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('payments_received')">
                        @langapp('receipts')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{formatCurrency($company->currency, $company->paid)}}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                {{ get_option('default_currency') }}
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-green-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-check-circle"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
        <div class="border-t border-gray-200 md:border-0 md:border-l">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-base font-normal leading-6 text-gray-900" data-toggle="tooltip" title="@langapp('balance_due')">
                        @langapp('outstanding')
                    </dt>
                    <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline {{themeText('text-2xl font-semibold leading-8')}}">
                            {{ formatCurrency($company->currency, $company->balance)}}
                            <span class="ml-2 text-sm font-medium leading-5 text-gray-500">
                                {{ get_option('default_currency') }}
                            </span>
                        </div>

                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full leading-5 text-red-500 md:mt-2 lg:mt-0">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
    </div>

</div>
<div class="col-md-5">
    <section class="panel panel-default">
        <section class="panel-body">
            @if($company->primary_contact > 0)
            <div class="clearfix m-b">
                <a href="#" class="pull-left thumb m-r">
                    <img src="{{ $company->logo}}" class="img-circle">
                </a>
                <div class="clear">
                    <div class="h3 m-t-xs m-b-xs">{{$company->name }}
                    </div>
                    <span class="text-gray-600">@icon('regular/user-circle') {{ $company->contact->name }}</span>
                    <br />
                    <span class="text-gray-600">@icon('solid/award') {{ optional($company->contact->profile)->job_title }}</span>
                </div>
            </div>
            @endif
            @can('clients_update')
            @if($company->email)
            <a href="{{ route('clients.email', ['client' => $company->id]) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                @icon('solid/paper-plane') @langapp('send_email')
            </a>
            @endif
            <a href="{{route('clients.edit', ['client' => $company->id])}}" class="btn {{themeButton()}}" data-toggle="ajaxModal"
                title="@langapp('edit')  ">@icon('solid/pencil-alt') @langapp('edit')
            </a>
            @endcan
            @can('clients_delete')
            <a href="{{route('clients.delete', ['client' => $company->id])}}" class="btn {{themeButton()}}" data-toggle="ajaxModal"
                title="@langapp('delete')  ">@icon('solid/trash-alt')</a>
            @endcan
            <div class="company_data">
                <div class="line"></div>
                <span class="m-3 text-sm text-gray-600 uppercase">@langapp('notes') </span>
                @parsedown($company->notes)
                <div class="line"></div>
                <h4 class="m-3 text-sm text-gray-600 uppercase">@langapp('information') </h4>
                <ul class="list-cust">
                    <li class="m-1">
                        <span class="text-gray-600">@langapp('phone') : </span>
                        <span class="font-semibold text-gray-600">
                            <a href="tel:{{$company->phone}}">{{$company->phone}}</a>
                        </span>
                    </li>
                    <li class="m-1">
                        <span class="text-gray-600">@langapp('mobile') : </span>
                        <span class="font-semibold text-gray-600">
                            <a href="tel:{{$company->mobile}}">{{$company->mobile}}</a>
                        </span>
                    </li>
                    <li class="m-1">
                        <span class="text-gray-600">@langapp('tax_number') : </span>
                        <span class="font-semibold text-gray-600">{{$company->tax_number}}</span>
                    </li>
                    <li class="m-1">
                        <span class="text-gray-600">@langapp('email') : </span>
                        <span class="font-semibold text-gray-600">
                            <a href="mailto:{{$company->email}}">{{$company->email}}</a>
                        </span>
                    </li>

                </ul>
                <div class="line"></div>
                <small class="text-xs text-gray-600 uppercase">@langapp('social') </small>
                <div class="m-1">
                    @if(!empty($company->skype))
                    <a href="skype:{{ $company->skype }}?call" class="btn btn-rounded btn-info btn-icon shadowed">
                        @icon('brands/skype')</a>
                    @endif
                    @if(!empty($company->twitter))
                    <a href="https://twitter.com/{{ $company->twitter }}" target="_blank" class="btn btn-rounded btn-twitter btn-icon shadowed">
                        @icon('brands/twitter')
                    </a>
                    @endif
                    @if(!empty($company->facebook))
                    <a href="https://facebook.com/{{ $company->facebook }}" target="_blank" class="btn btn-rounded btn-info btn-icon shadowed">
                        @icon('brands/facebook')
                    </a>
                    @endif
                    @if(!empty($company->linkedin))
                    <a href="https://linkedin.com/in/{{ $company->linkedin }}" target="_blank" class="btn btn-rounded btn-primary btn-icon shadowed">
                        @icon('brands/linkedin')
                    </a>
                    @endif
                    @if(!empty($company->website))
                    <a href="{{ $company->website }}" target="_blank" class="btn btn-rounded btn-danger btn-icon shadowed">
                        @icon('solid/link')
                    </a>
                    @endif
                </div>
                <div class="line"></div>
                <h4 class="mb-2 font-semibold text-gray-500 uppercase">@langapp('billing_address') </h4>
                @if(!empty($company->billing_street))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('address')</small>
                    <p>{{ $company->billing_street }}</p>
                </div>
                @endif
                @if(!empty($company->billing_city))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('city')</small>
                    <p>{{ $company->billing_city }}</p>
                </div>
                @endif
                @if(!empty($company->billing_state))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('state')</small>
                    <p>{{ $company->billing_state }}</p>
                </div>
                @endif

                @if(!empty($company->billing_zip))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('zipcode')</small>
                    <p>{{ $company->billing_zip }}</p>
                </div>
                @endif
                @if(!empty($company->billing_country))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('country')</small>
                    <p>{{ $company->billing_country }}</p>
                </div>
                @endif

                <div class="line"></div>
                <h4 class="mb-2 font-semibold text-gray-500 uppercase">@langapp('shipping_address') </h4>
                @if(!empty($company->shipping_street))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('address')</small>
                    <p>{{ $company->shipping_street }}</p>
                </div>
                @endif
                @if(!empty($company->shipping_city))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('city')</small>
                    <p>{{ $company->shipping_city }}</p>
                </div>
                @endif
                @if(!empty($company->shipping_state))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('state')</small>
                    <p>{{ $company->shipping_state }}</p>
                </div>
                @endif

                @if(!empty($company->shipping_zip))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('zipcode')</small>
                    <p>{{ $company->shipping_zip }}</p>
                </div>
                @endif
                @if(!empty($company->shipping_country))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('country')</small>
                    <p>{{ $company->shipping_country }}</p>
                </div>
                @endif
                <div class="line"></div>

                @if(!empty($company->locale))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('locale')</small>
                    <p>{{ $company->locale }}</p>
                </div>
                @endif
                @if(!empty($company->currency))
                <div class="text-sm text-gray-600">
                    <small class="font-semibold uppercase">@langapp('currency')</small>
                    <p>{{ $company->currency }}</p>
                </div>
                @endif
                <div class="map">
                    <a href="{{ $company->maplink }}" rel="nofollow" target="_blank">
                        <img src="//maps.googleapis.com/maps/api/staticmap?center={{ $company->map }}&amp;zoom=14&amp;scale=2&amp;size=600x340&amp;maptype=roadmap&amp;format=png&amp;visual_refresh=true&amp;key={{ config('system.google.mapkey') }}"
                            alt="Google Map">

                    </a>
                </div>
                @widget('CustomFields\Extras', ['custom' => $company->custom])
                <small class="text-xs text-gray-600 uppercase">
                    @langapp('vaults')
                    <a href="{{ route('extras.vaults.create', ['module' => 'clients', 'id' => $company->id]) }}" class="btn btn-xs btn-danger pull-right"
                        data-toggle="ajaxModal">@icon('solid/plus')</a>
                </small>
                <div class="line"></div>
                @widget('Vaults\Show', ['vaults' => $company->vault])
                <div class="line"></div>
                <small class="text-xs text-gray-600 uppercase">@langapp('tags')</small>
                <div class="m-1">
                    @php
                    $data['tags'] = $company->tags;
                    @endphp
                    @include('partial.tags', $data)
                </div>
            </div>
        </section>
    </section>
</div>
<div class="col-md-7">
    <section class="scrollable wrapper">
        <section class="block comment-list">
            <article class="comment-item" id="comment-form">
                <a class="pull-left thumb-sm avatar">
                    <img src="{{ avatar() }}" class="img-circle">
                </a>
                <span class="arrow left"></span>
                <section class="comment-body">
                    <section class="p-2 panel panel-default">
                        @widget('Comments\CreateWidget', ['commentable_type' => 'clients' , 'commentable_id' => $company->id])
                    </section>
                </section>
            </article>
            @widget('Comments\ShowComments', ['comments' => $company->comments])
        </section>
    </section>
</div>
@push('pagescript')
@include('comments::_ajax.ajaxify')
@include('partial.ajaxify')
@endpush