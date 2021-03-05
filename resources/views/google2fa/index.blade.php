@extends('layouts.auth')
@section('content')
<div class="content">
    <section id="content" class="wrapper-md content">

        <div id="login-darken"></div>
        <div id="login-form" class="container max-w-md aside-xxl animated fadeInUp">
            <span class="navbar-brand mt-8 font-semibold text-center text-2xl leading-8 block {{ settingEnabled('blur_login') ? 'text-white' : themeText() }}">
                @php $display = get_option('logo_or_icon'); @endphp
                @if ($display == 'logo' || $display == 'logo_title')
                <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('company_logo')) }}" class="img-responsive {{ ($display == 'logo' ? '' : 'thumb-sm mr-1') }}">
                @elseif ($display == 'icon' || $display == 'icon_title')
                <i class="{{ get_option('site_icon') }}"></i>
                @endif
                @if ($display == 'logo_title' || $display == 'icon_title')
                @if (get_option('website_name') == '')
                {{ get_option('company_name') }}
                @else
                {{ get_option('website_name') }}
                @endif
                @endif
            </span>
            <section class="bg-white panel panel-default m-t-sm b-r-xs">
                <header class="px-2 py-3 text-center text-white {{themeBg()}} border-b border-gray-200 rounded-t-sm">{{ langapp('2fa_authentication') }}</header>


                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('2fa.auth') }}">
                        {{ csrf_field() }}
                        @if ($errors->has('message'))
                        <x-alert type="warning" icon="solid/exclamation-circle" class="text-sm leading-5">
                            {{ $errors->first('message') }}
                        </x-alert>
                        @endif
                        <p>@langapp('enter_auth_code')</p>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="one_time_password" type="text" class="form-control" name="one_time_password" placeholder="XXXXXX" required autofocus>
                            </div>
                        </div>
                        <button type="submit" class="btn {{themeButton()}} btn-block">@langapp('login')</button>
                        <div class="m-sm">
                            <a href="{{ url('/logout') }}" class="{{themeLinks('font-semibold')}}">@langapp('cancel')</a> | <a href="{{ route('2fa.reset') }}"
                                class="{{themeLinks('font-semibold')}}">@langapp('reset_2fa')</a>
                        </div>


                    </form>
                </div>
                {{-- footer --}}
                @if (get_option('hide_branding') == 'FALSE')
                <footer id="footer copyright-footer">
                    <div class="text-center text-muted padder">
                        <p>
                            @include('partial.copyright')
                        </p>
                    </div>
                </footer>
                @endif
                {{-- /footer --}}
            </section>
        </div>
    </section>
</div>
@endsection