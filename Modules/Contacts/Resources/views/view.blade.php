@extends('layouts.app')
@section('content')
<section id="content">
  <section class="vbox">
    <header class="bg-white header b-b b-light">
      <p class="">{{ $contact->name }}</p>

      @can('contacts_delete')

      <a href="{{ route('users.delete', ['user' => $contact->id]) }}" data-toggle="ajaxModal" class="btn {{themeButton()}} pull-right">
        @icon('solid/trash-alt') @langapp('delete')
      </a>

      @endcan
      @can('deals_create')

      <a href="{{ route('deals.create', ['contact' => $contact->id, 'company' => $contact->profile->company]) }}" data-toggle="ajaxModal" class="btn {{themeButton()}} pull-right">
        @icon('solid/award') @langapp('deal')
      </a>

      @endcan

      @can('users_update')
      <a href="{{ route('users.edit', ['user' => $contact->id]) }}" data-toggle="ajaxModal" class="btn {{themeButton()}} pull-right">
        @icon('solid/pencil-alt') @langapp('edit')
      </a>
      @endcan


    </header>
    <section class="scrollable bg">

      <section class="hbox stretch">


        <aside class="aside-lg b-r">

          <section class="wrapper">


            <div class="clearfix m-b">
              <a href="#" class="pull-left thumb m-r">
                <img src="{{ $contact->profile->photo }}" class="img-circle">
              </a>
              <div class="clear">
                <div class="h3 m-t-xs m-b-xs">{{ $contact->name }}</div>
                <small class="text-gray-600">@icon('solid/id-badge') {{ $contact->profile->job_title }}</small>
              </div>
            </div>
            <div class="panel wrapper panel-success">
              <div class="row">
                <div class="col-xs-6">
                  <a href="#">
                    <span class="block m-b-xs h4"> {{ $contact->comments->count() }}</span>
                    <small class="text-gray-600">@langapp('comments') </small>
                  </a>
                </div>
                <div class="col-xs-6">
                  <a href="#">
                    <span class="block m-b-xs h4">{{ $contact->activities->count() }}</span>
                    <small class="text-gray-600">@langapp('activity') </small>
                  </a>
                </div>
              </div>
            </div>

            <div>
              @if(!empty($contact->email))
              <span class="text-xs text-gray-600 uppercase">@langapp('email') </span>
              <p class="p-2">{{ $contact->email }}</p>
              @endif

              @if($contact->profile->company > 0)
              <span class="text-gray-600 uppercase">@langapp('company_name') </span>
              <p class="p-2">
                <a href="{{ route('clients.view', $contact->profile->company) }}" class="{{themeLinks('font-semibold')}}">{{ $contact->profile->business->name }}</a>
              </p>
              @endif
              @if(!empty($contact->profile->address))
              <span class="text-xs text-gray-600 uppercase">@langapp('address') </span>
              <p class="p-2">{{ $contact->profile->address }}</p>
              @endif
              @if(!empty($contact->profile->phone))
              <span class="text-xs text-gray-600 uppercase">@langapp('phone') </span>
              <p class="p-2">{{ $contact->profile->phone }}</p>
              @endif
              @if(!empty($contact->profile->mobile))
              <span class="text-xs text-gray-600 uppercase">@langapp('mobile') </span>
              <p class="p-2">{{ $contact->profile->mobile }}</p>
              @endif
              @if(!empty($contact->profile->city))
              <span class="text-xs text-gray-600 uppercase">@langapp('city') </span>
              <p class="p-2">{{ $contact->profile->city }}</p>
              @endif
              @if(!empty($contact->profile->state))
              <span class="text-xs text-gray-600 uppercase">@langapp('state') </span>
              <p class="p-2">{{ $contact->profile->state }}</p>
              @endif
              @if(!empty($contact->profile->zip_code))
              <span class="text-xs text-gray-600 uppercase">@langapp('zipcode') </span>
              <p class="p-2">{{ $contact->profile->zip_code }}</p>
              @endif
              @if(!empty($contact->profile->country))
              <span class="text-xs text-gray-600 uppercase">@langapp('country') </span>
              <p class="p-2">{{ $contact->profile->country }}</p>
              @endif
              @if(!empty($contact->locale))
              <span class="text-xs text-gray-600 uppercase">@langapp('locale') </span>
              <p class="p-2">{{ $contact->locale }}</p>
              @endif

              <div class="line"></div>
              <span class="text-xs text-gray-600 uppercase">Connection</span>
              <p class="mt-1">
                @if(!empty($contact->profile->twitter))
                <a href="https://twitter.com/{{ $contact->profile->twitter }}" class="btn btn-rounded btn-twitter btn-icon">@icon('brands/twitter')
                  @endif

                  @if(!empty($contact->profile->skype))
                  <a href="skype:{{ $contact->profile->skype }}?call" class="btn btn-rounded btn-info btn-icon">@icon('brands/skype')</a>
                  @endif

                  <a href="{{ route('contacts.email', $contact->id) }}" class="btn btn-rounded btn-dracula btn-icon" data-toggle="ajaxModal">
                    @icon('solid/envelope-open')
                  </a>
              </p>


              @admin
              <div class="line"></div>
              <span class="text-xs text-gray-600 uppercase">@langapp('tags') </span>
              <div class="m-xs">
                @php
                $data['tags'] = $contact->tags;
                @endphp
                @include('partial.tags', $data)
              </div>
              @endadmin



            </div>

          </section>

        </aside>
        <aside class="bg-white">
          <section class="vbox">

            <section class="bg">

              <div class="uppercase sub-tab small m-b-sm">

                <ul class="nav pro-nav-tabs nav-tabs-dashed">
                  <li class="{{ ($tab == 'conversations') ? 'active' : '' }}">
                    <a href="{{ route('contacts.view', ['user' => $contact->id, 'tab' => 'conversations']) }}">
                      @icon('solid/envelope-open') @langapp('emails')
                    </a>
                  </li>

                  <li class="{{ ($tab == 'calls') ? 'active' : '' }}">
                    <a href="{{ route('contacts.view', ['user' => $contact->id, 'tab' => 'calls']) }}">
                      @icon('solid/phone') @langapp('calls')
                    </a>
                  </li>

                  <li class="{{  ($tab == 'sms') ? 'active' : ''  }}">
                    <a href="{{  route('contacts.view', ['user' => $contact->id, 'tab' => 'sms'])  }}">
                      @icon('solid/sms') SMS
                    </a>
                  </li>


                </ul>

              </div>

              @include('contacts::tab.'.$tab)

            </section>
          </section>
        </aside>

      </section>
    </section>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>
@push('pagestyle')
@include('stacks.css.wysiwyg')
@include('stacks.css.datepicker')
@endpush
@push('pagescript')
@include('stacks.js.datepicker')
@include('stacks.js.wysiwyg')
<script>
  $('.datetimepicker-input').datetimepicker({showClose: true, showClear: true, minDate: moment() });
   
    $( "#sendLater" ).click(function() {
      $("#queueLater").show("fast");
      $( ".datetimepicker-input" ).focus();
    });

</script>
@endpush
@endsection