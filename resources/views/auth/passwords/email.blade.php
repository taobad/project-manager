@extends('layouts.auth')

@section('content')


<section id="content" class="wrapper-md content">


    <div id="login-darken"></div>
    <div id="login-form" class="container max-w-md aside-xxl animated fadeInUp">

        <span class="navbar-brand mt-8 font-semibold text-center text-2xl leading-8 block {{ settingEnabled('blur_login') ? 'text-white' : themeText() }}">
            <img src="/images/lupinga-logo-transparent.png" class="img-responsive {{ ($display == 'logo' ? '' : 'thumb-sm m-r-sm') }}"> LupingaPM
        </span>

        <section class="bg-white panel panel-default m-t-sm b-r-xs">
            <header class="px-2 py-3 text-center text-white {{themeBg()}} border-b border-gray-200 rounded-t-sm">@langapp('reset_password')</header>
            {!! Form::open(['route' => 'password.email', 'class' => 'panel-body wrapper-lg']) !!}

            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">@langapp('email') @required</label>

                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif

            </div>

            <button type="submit" class="btn {{themeButton()}} btn-block">@langapp('send_reset_password') </button>

            <a href="{{ route('login') }}" class="btn {{themeButton()}} btn-block">
                @icon('solid/sign-in-alt')
                @langapp('login')
            </a>


            {!! Form::close() !!}

            {{-- Footer --}}
            @if (!settingEnabled('hide_branding'))
            @include('partial.branding')
            @endif
            {{-- /Footer --}}





        </section>

</section>
@endsection