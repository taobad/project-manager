@extends('layouts.auth')

@section('content')


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
            <header class="px-2 py-3 text-center text-white {{themeBg()}} border-b border-gray-200 rounded-t-sm">
                @langapp('reset_password')
            </header>
            {!! Form::open(['route' => 'password.request', 'class' => 'panel-body wrapper-lg']) !!}
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">@langapp('email')</label>

                <input id="email" type="email" class="form-control" name="email" placeholder="you@domain.com" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password">@langapp('password')</label>

                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm">@langapp('confirm_password')</label>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif

            </div>
            <button type="submit" class="btn {{themeButton()}} btn-block">@langapp('reset_password')</button>
            {!! Form::close() !!}

            {{-- Footer --}}
            @if (!settingEnabled('hide_branding'))
            @include('partial.branding')
            @endif
            {{-- /Footer --}}
        </section>
        @endsection