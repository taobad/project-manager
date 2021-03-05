<div class="row">
    <div class="col-lg-4 b-r">
        <section class="panel panel-default">
            <header class="panel-heading">@langapp('overview')

            </header>
            <section class="panel-body">

                <p id="status-buttons">
                    <a href="#" data-id="hot" data-toggle="tooltip" title="Mark as @langapp('hot')"
                        class="rating-btn btn btn-rounded btn-sm btn-icon btn-default {{$lead->rating_status == 'hot' ? 'bg-blue-700 text-white' : ''}}">@icon('solid/fire','text-'.leadRatingClr('hot'))</a>
                    <a href="#" data-id="warm" data-toggle="tooltip" title="Mark as @langapp('warm')"
                        class="rating-btn btn btn-rounded btn-sm btn-icon btn-default {{$lead->rating_status == 'warm' ? 'bg-blue-700 text-white':''}}">@icon('solid/fire','text-'.leadRatingClr('warm'))</a>
                    <a href="#" data-id="cold" data-toggle="tooltip" title="Mark as @langapp('cold')"
                        class="rating-btn btn btn-rounded btn-sm btn-icon btn-default {{$lead->rating_status == 'cold' ? 'bg-blue-700 text-white' : ''}}">@icon('solid/fire','text-'.leadRatingClr('cold'))</a>
                </p>

                <div class="m-xs">
                    <span class="text-muted">@langapp('created_at'):</span>
                    <span class="text-bold">{{dateFormatted($lead->created_at)}}</span>
                </div>

                <div class="m-xs">
                    <span class="text-muted">@langapp('stage'):</span>
                    <span class="text-bold text-danger">{{ucfirst($lead->status->name)}}</span>
                </div>

                <div class="m-xs">
                    <span class="text-muted">@langapp('source'):</span>
                    <span class="text-bold">{{$lead->AsSource->name}}</span>
                </div>

                <div class="m-xs">
                    <span class="text-muted">{{ langapp('lead_age')}}:</span>
                    <span class="text-bold">{{ $lead->created_at->diffForHumans() }}</span>
                </div>

                <div class="m-xs">
                    <span class="text-muted">{{ langapp('lead_value') }}:</span>
                    <span class="text-bold">{{ $lead->computed_value }}</span>
                </div>

                <div class="m-xs">
                    <span class="text-muted">@langapp('next_followup'):</span>
                    <span class="text-bold">{{dateFormatted($lead->next_followup)}}</span>
                </div>

                <div class="m-xs m-b-sm">
                    <span class="text-muted" data-rel="tooltip" title="GDPR Privacy">{{langapp('data_processing')}}:</span>
                    <span class="text-bold text-danger">{{ is_null($lead->unsubscribed_at) ? '✔︎' : '✘' }}
                        @if(!is_null($lead->unsubscribed_at))
                        <a href="{{ route('leads.consent', ['lead' => $lead->id]) }}" class="btn btn-xs btn-success" data-rel="tooltip"
                            title="Send Consent">@icon('solid/user-lock')</a>
                        @endif
                    </span>
                </div>

                <div class="progress progress-xs progress-striped">
                    <div class="progress-bar progress-bar-success" data-toggle="tooltip" data-original-title="{{ $lead->score }}%" style="width:{{ $lead->score }}%"></div>
                </div>

                @if ($lead->sales_rep > 0)

                <h4 class="font-thin">@langapp('sales_rep')</h4>

                <div class="line"></div>

                <span class="my-2 thumb-sm avatar lobilist-check">
                    <img src="{{ $lead->agent->profile->photo}}" class="inline img-circle">
                </span> <strong>{{ $lead->agent->name }}</strong>
                @endif
                <h4 class="font-thin">Lead Profile</h4>
                <div class="line"></div>

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
                <small class="text-xs text-uc text-muted">@langapp('message') </small>
                <div class="m-xs with-responsive-img">
                    @parsedown($lead->message)
                </div>

            </section>
        </section>
        <section class="panel panel-default">
            <header class="panel-heading">@langapp('extras') </header>
            <section class="panel-body">

                @foreach ($lead->custom as $key => $field)
                @if (App\Entities\CustomField::whereName($field->meta_key)->count() > 0)

                <small class="text-xs text-uc text-muted">{{ucfirst(humanize($field->meta_key, '-'))}}</small>
                <p>{{ isJson($field->meta_value) ? implode(', ', json_decode($field->meta_value)) : $field->meta_value }}</p>




                @endif
                @endforeach
            </section>
        </section>
        <section class="panel panel-default">
            <header class="panel-heading">@langapp('activities') </header>
            <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="500px" data-size="3px">
                @widget('Activities\Feed', ['activities' => $lead->activities])
            </div>
        </section>
    </div>

    <div class="col-lg-8">

        @php
        $data = [
        'notes' => $lead->notes, 'noteable_type' => get_class($lead),
        'title' => $lead->name.' Note', 'noteable_id' => $lead->id
        ];
        @endphp

        @widget('Notes\ShowNotes', $data)

    </div>

</div>

@push('pagescript')
<script>
    $(".rating-btn").click(function(e) {
            e.preventDefault();
            status = $(this).data("id");
            axios.post('{{ route('leads.rating') }}', {
                id: {{ $lead->id }},
                rating: status,
            })
            .then(function (response) {
                toastr.success( response.data.message , '@langapp('response_status') ');
                window.location.href = response.data.redirect;
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>';
                });
                toastr.error( errorsHtml , '@langapp('response_status') ');
            });  
        });
</script>
@endpush