<div class="row">
    <div class="col-lg-4 b-r">
        <section class="panel panel-default">
            <header class="panel-heading">@langapp('profile')</header>
            <section class="panel-body">

                @if ($lead->sales_rep > 0)
                <small class="text-xs text-uc text-muted">@langapp('sales_rep') </small>
                <p>{{ $lead->agent->name }}</p>

                @endif

                @if(!empty($lead->name))
                <small class="text-xs text-uc text-muted">@langapp('name') </small>
                <p>{{ $lead->name }}</p>
                @endif

                @if(!empty($lead->email))
                <small class="text-xs text-uc text-muted">@langapp('email') </small>
                <p>{{ $lead->email }}</p>
                @endif
                @if(!empty($lead->mobile))
                <small class="text-xs text-uc text-muted">@langapp('mobile') </small>
                <p>{{ $lead->mobile }}
                    @if(settingEnabled('whatsapp_enabled'))
                    <span class="text-bold text-danger">
                        @if(!$lead->whatsapp_optin)
                        <a href="{{ route('leads.consent.whatsapp', $lead->id) }}" class="btn btn-xs btn-success" data-rel="tooltip"
                            title="Request whatsapp consent">@icon('brands/whatsapp') @langapp('subscribe')</a>
                        @endif
                    </span>
                    @endif
                    <a href="web+aircall:{{ $lead->mobile }}" data-rel="tooltip" title="@langapp('call_via_aircall')">@icon('solid/phone','text-success')</a>
                </p>
                @endif

                @if(!empty($lead->phone))
                <small class="text-xs text-uc text-muted">@langapp('phone') </small>
                <p>{{ formatPhoneNumber($lead->phone) }}</p>
                @endif

                @if(!empty($lead->company))
                <small class="text-xs text-uc text-muted">@langapp('company_name') </small>
                <p>{{ $lead->company }}</p>
                @endif

                @if(!empty($lead->timezone))
                <small class="text-xs text-uc text-muted">@langapp('timezone') </small>
                <p>{{ $lead->timezone }}</p>
                @endif

                @if(!empty($lead->address1))
                <small class="text-xs text-uc text-muted">@langapp('address') 1 </small>
                <p>{{ $lead->address1 }}</p>
                @endif

                @if(!empty($lead->address2))
                <small class="text-xs text-uc text-muted">@langapp('address') 2 </small>
                <p>{{ $lead->address2 }}</p>
                @endif

                @if(!empty($lead->city))
                <small class="text-xs text-uc text-muted">@langapp('city') </small>
                <p>{{ $lead->city }}</p>
                @endif

                @if(!empty($lead->zip_code))
                <small class="text-xs text-uc text-muted">@langapp('zipcode') </small>
                <p>{{ $lead->zip_code }}</p>
                @endif

                @if(!empty($lead->state))
                <small class="text-xs text-uc text-muted">@langapp('state') </small>
                <p>{{ $lead->state }}</p>
                @endif

                @if(!empty($lead->country))
                <small class="text-xs text-uc text-muted">@langapp('country') </small>
                <p>{{ $lead->country }}</p>
                @endif



                <div class="m-xs">
                    @if(!empty($lead->skype))

                    <a href="skype:{{ $lead->skype }}?call" class="btn btn-rounded btn-info btn-icon shadowed">
                        @icon('brands/skype')</a>

                    @endif

                    @if(!empty($lead->twitter))
                    <a href="{{ $lead->twitter }}" target="_blank" class="btn btn-rounded btn-twitter btn-icon shadowed">
                        @icon('brands/twitter')
                    </a>
                    @endif

                    @if(!empty($lead->facebook))
                    <a href="{{ $lead->facebook }}" target="_blank" class="btn btn-rounded btn-info btn-icon shadowed">
                        @icon('brands/facebook')
                    </a>
                    @endif

                    @if(!empty($lead->linkedin))
                    <a href="{{ $lead->linkedin }}" target="_blank" class="btn btn-rounded btn-primary btn-icon shadowed">
                        @icon('brands/linkedin')
                    </a>
                    @endif

                    @if(!empty($lead->website))
                    <a href="{{ $lead->website }}" target="_blank" class="btn btn-rounded btn-danger btn-icon shadowed">
                        @icon('solid/link')
                    </a>
                    @endif

                </div>

                <div class="map">
                    <a href="{{ $lead->maplink }}" rel="nofollow" target="_blank">
                        <img src="//maps.googleapis.com/maps/api/staticmap?center={{ $lead->map }}&amp;zoom=14&amp;scale=2&amp;size=600x340&amp;maptype=roadmap&amp;format=png&amp;visual_refresh=true&amp;key={{ config('system.google.mapkey') }}"
                            alt="Google Map">
                    </a>
                </div>



                <div class="line"></div>
                <small class="text-xs text-uc text-muted">@langapp('tags') </small>
                <div class="m-xs">
                    @php
                    $data['tags'] = $lead->tags;
                    @endphp
                    @include('partial.tags', $data)
                </div>

                <div class="line"></div>
                <small class="text-xs text-uc text-muted">@langapp('message')</small>
                <div class="m-xs with-responsive-img">
                    @parsedown($lead->message)
                </div>

            </section>
        </section>
        <section class="panel panel-default">
            <header class="panel-heading">@langapp('extras')</header>
            <section class="panel-body">

                @foreach ($lead->custom as $key => $field)
                @if (App\Entities\CustomField::whereName($field->meta_key)->count() > 0)

                <small class="text-xs text-uc text-muted">{{  ucfirst(humanize($field->meta_key, '-'))  }}</small>
                <p>{{ isJson($field->meta_value) ? implode(', ', json_decode($field->meta_value)) : $field->meta_value }}</p>
                @endif
                @endforeach
            </section>
        </section>

    </div>

    <div class="col-lg-8">
        <section class="" id="taskapp">
            <aside>
                <section class="">
                    <section class="panel panel-default">
                        <header class="panel-heading">WhatsApp Conversation</header>
                        <section class="bg chat-list panel-body">
                            <section class="panel panel-default">
                                @widget('Chats\CreateWidget', ['chatable_type' => 'leads' , 'chatable_id' => $lead->id, 'cannedResponse' => true])
                            </section>
                            @asyncWidget('Chats\WhatsApp', ['chatable_id' => $lead->id, 'chatable_type' => 'leads'])
                        </section>

                    </section>
                </section>
            </aside>
        </section>
    </div>
</div>
@include('extras::_ajax.ajaxify_chat')