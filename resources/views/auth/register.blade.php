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
            <header class="px-2 py-3 text-center text-white {{themeBg()}} border-b border-gray-200 rounded-t-sm">{{ get_option('login_title') }}</header>

            @if (settingEnabled('enable_languages'))
            <div class="clearfix text-right m-xs">

                <div class="btn-group dropdown">
                    <button type="button" class="dropdown-toggle {{themeButton()}}" data-toggle="dropdown">
                        @icon('solid/globe') @langapp('languages')
                        <span class="caret"></span>
                    </button>

                    <!-- Load Languages -->
                    <ul class="text-left dropdown-menu">
                        @foreach (languages() as $lang)
                        @if ($lang['active'] == 1)
                        <li>
                            <a href="{{ route('setLanguage', $lang['code']) }}" title="{{ ucwords(str_replace('_', ' ', $lang['name'])) }}">
                                {{ ucwords(str_replace('_', ' ', $lang['name'])) }}
                            </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {!! Form::open(['route' => 'register', 'class' => 'panel-body wrapper-lg']) !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">@langapp('fullname') @required</label>
                <input id="name" type="text" class="form-control" name="name" placeholder="John Doe" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">@langapp('contact_email') @required</label>
                <input id="email" type="email" class="form-control" placeholder="johndoe@example.com" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                <label for="mobile">@langapp('mobile')</label>
                <input id="mobile" type="text" class="form-control" placeholder="+14081234567" name="mobile" value="{{ old('mobile') }}" required>

                @if ($errors->has('mobile'))
                <span class="help-block">
                    <strong>{{ $errors->first('mobile') }}</strong>
                </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                <label for="company_name">@langapp('company_name')</label>
                <input id="company_name" type="text" class="form-control" placeholder="ACME co," name="company" value="{{ old('company') }}" required>

                @if ($errors->has('company'))
                <span class="help-block">
                    <strong>{{ $errors->first('company') }}</strong>
                </span>
                @endif

            </div>
            <div class="form-group{{ $errors->has('company_email') ? ' has-error' : '' }}">
                <label for="company_email">@langapp('company_email') @required</label>
                <input id="email" type="email" class="form-control" placeholder="johndoe@company.com" name="company_email" value="{{ old('company_email') }}" required>

                @if ($errors->has('company_email'))
                <span class="help-block">
                    <strong>{{ $errors->first('company_email') }}</strong>
                </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password">@langapp('password') @required</label>

                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password-confirm">@langapp('confirm_password') @required</label>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

            </div>

            <div class="form-group {{ $errors->has('agree_terms') ? ' has-error' : '' }}">

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="agree_terms" {{ old('agree_terms') ? 'checked' : '' }}>
                        <span class="label-text">Agree to terms and <a href="{{ get_option('privacy_policy_url') }}" class="text-blue-600" target="_blank">privacy policy</a></span>
                    </label>
                </div>

                @if ($errors->has('agree_terms'))
                <span class="help-block">
                    <strong>{{ $errors->first('agree_terms') }}</strong>
                </span>
                @endif

            </div>

            <button type="submit" class="btn {{themeButton()}} btn-block">
                @icon('regular/check-circle') @langapp('register')
            </button>
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

    </div>
</section>
@endsection