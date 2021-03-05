@extends('layouts.auth')
@section('content')
<div class="content">
    <section id="content" class="m-t-lg wrapper-md m-t-cust">
        <div id="login-darken"></div>
        <div id="login-form" class="container max-w-md aside-xxl animated fadeInUp">
            <span class="navbar-brand block {{ (get_option('blur_login') == 'TRUE') ? 'text-white' : 'logo-text' }}">
                @php $display = get_option('logo_or_icon'); @endphp
                @if ($display == 'logo' || $display == 'logo_title')
                <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('company_logo')) }}"
                    class="img-responsive {{ ($display == 'logo' ? '' : 'thumb-sm m-r-sm') }}">
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
            <section class="panel panel-default bg-white-cust m-t-lg b-r-cust">
                <header class="text-center panel-heading">
                    <strong>@langapp('verify_email_address')</strong>
                </header>

                <div class="panel-body">
                    <div class="col-md-12">
                        @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            @langapp('verification_email_sent')
                        </div>
                        @endif

                        <span class="help-block">
                            <strong>@langapp('account_requires_verification')</strong>
                        </span>
                        <div class="form-group">
                            @langapp('verification_warning')
                            <div class="m-t-sm">
                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block">
                                        @icon('solid/paper-plane') @langapp('resend')
                                    </button>.
                                </form>
                                {{-- <a href="{{ route('verification.resend') }}" class="btn btn-danger btn-block">
                                @icon('solid/paper-plane') @langapp('resend')
                                </a> --}}
                            </div>

                        </div>


                    </div>
                </div>
                <!-- footer -->
                @if (get_option('hide_branding') == 'FALSE')
                <footer id="footer" class="copyright-footer">
                    <div class="text-center text-muted padder">
                        <p>
                            @include('partial.copyright')
                        </p>
                    </div>
                </footer>
                @endif
                <!-- / footer -->
            </section>
        </div>
    </section>
</div>
@endsection