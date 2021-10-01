@extends('layouts.auth')

@section('content')


<section id="content" class="m-t-lg wrapper-md content">

    <div id="login-darken"></div>
    <div id="login-form" class="container max-w-md aside-xxl animated fadeInUp">
        <span class="navbar-brand mt-8 font-semibold text-center text-2xl leading-8 block {{ settingEnabled('blur_login') ? 'text-white' : themeText() }}">
            <img src="/images/lupinga-logo-transparent.png" class="img-responsive {{ ($display == 'logo' ? '' : 'thumb-sm m-r-sm') }}"> LupingaPM
        </span>

        <section class="bg-white panel panel-default m-t-sm b-r-xs">
            <header class="px-2 py-3 text-center text-white {{themeBg()}} border-b border-gray-200 rounded-t-sm">
                <strong>@langapp('confirm_password_to_continue')</strong>
            </header>
            <form class="panel-body wrapper-lg" method="POST" action="{{ route('users.reauthenticate.process') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">@langapp('password')</label>

                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif

                </div>
                <div class="form-group">
                    <button type="submit" class="btn {{themeButton()}} btn-block">
                        @icon('solid/unlock-alt') @langapp('confirm_password')</button>

                    <p class="mt-1 text-muted"><strong>Tip:</strong> You are entering sudo mode. You will not be asked
                        for your password for a few hours.</p>

                    <a href="{{ route('dashboard.index') }}" class="btn {{themeButton()}} btn-block">
                        @icon('solid/home')
                        @langapp('back')
                    </a>
                </div>
                <div class="line line-dashed">
                </div>
            </form>

            @if (!settingEnabled('hide_branding'))
            @include('partial.branding')
            @endif

        </section>

    </div>
</section>

@endsection