@extends('layouts.app')

@section('content')

<section id="content" class="bg-indigo-100">
    <section class="hbox stretch">

        @include('settings::partial.menu')

        <aside>
            <section class="vbox">

                <header class="clearfix bg-white header b-b">
                    <div class="row m-t-sm">
                        <div class="col-sm-12 m-b-xs">

                            @if($section == 'payments')
                            <a href="{{ route('settings.index', 'currencies') }}" class="btn {{themeButton()}}">@langapp('currencies')</a>
                            @endif

                            @if($section == 'theme')
                            <a href="{{ route('settings.index', 'css') }}" class="btn {{themeButton()}}">@langapp('custom_css')</a>
                            @endif

                            @if($section == 'system' || $section == 'mail' || $section == 'integrations' || $section == 'extras')
                            @admin
                            @if($section != 'mail')
                            <a href="{{ route('settings.index', 'mail') }}" class="btn {{themeButton()}}">@icon('solid/envelope-open-text') Mail Settings</a>
                            @endif
                            @if($section != 'integrations')
                            <a href="{{ route('settings.index', 'integrations') }}" class="btn {{themeButton()}}">@icon('solid/terminal') @langapp('integrations')</a>
                            @endif
                            @if($section != 'extras')
                            <a href="{{ route('settings.index', 'extras') }}" class="btn {{themeButton()}}">@icon('solid/wrench') @langapp('extras') </a>
                            @endif
                            <a href="{{ route('settings.test.mail') }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">@icon('solid/at') @langapp('test_email')</a>
                            @endadmin
                            @endif

                            @if($section == 'info')
                            @admin
                            <div class="btn-group">
                                <button class="btn {{themeButton()}} dropdown-toggle" data-toggle="dropdown" aria-expanded="false">@langapp('import') <span
                                        class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('settings.import', ['type' => 'fo']) }}" data-toggle="ajaxModal">Freelancer Office</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('settings.index', 'commands') }}" class="btn {{themeButton()}}">@icon('solid/terminal') Commands</a>
                            <a href="#" class="btn {{themeButton()}} pull-right" id="updatesInstallBtn" data-rel="tooltip" title="Install available updates">
                                @icon('solid/laptop-code') @langapp('install_updates')
                            </a>
                            @endadmin
                            @endif

                            @if($section == 'support')
                            <a href="{{ route('settings.statuses.show') }}" class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip" title="@langapp('statuses')"
                                data-placement="bottom">
                                @icon('solid/ellipsis-v') @langapp('statuses')
                            </a>
                            @endif

                            @if($section == 'translations')
                            <a href="{{ route('translations.mail') }}" class="btn {{themeButton()}}" data-rel="tooltip" title="Modify email templates" data-placement="bottom">
                                @icon('solid/envelope-open') @langapp('emails')
                            </a>
                            @endif
                            @if($section == 'leads')
                            <a href="{{ route('settings.stages.show', 'leads') }}" class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip"
                                title="@langapp('preview') " data-placement="bottom">
                                @icon('solid/shoe-prints') @langapp('stages')
                            </a>

                            <a href="{{ route('settings.sources.show') }}" class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip" title="@langapp('source') "
                                data-placement="bottom">
                                @icon('solid/globe') @langapp('source')
                            </a>

                            <a href="{{ route('web.lead') }}" class="btn {{themeButton()}} pull-right" data-rel="tooltip" title="Web to Lead form" data-placement="bottom"
                                target="_blank">
                                @icon('solid/phone-volume') @langapp('lead_form')
                            </a>

                            @endif

                            @if($section == 'deals')
                            <a href="{{ route('settings.stages.show', 'deals') }}" class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip"
                                title="@langapp('stages') " data-placement="bottom">
                                @icon('solid/shoe-prints') @langapp('stages')
                            </a>
                            <a href="{{ route('settings.pipelines.show') }}" class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip"
                                title="@langapp('deal_pipelines')" data-placement="bottom">
                                @icon('solid/chart-line') @langapp('deal_pipelines')
                            </a>
                            @endif


                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper">
                    @include('settings::sections.'.$section)
                </section>
            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html">

    </a>
</section>
@modactive('updates')
@push('pagescript')
<script>
    $("#updatesInstallBtn").click(function() {
        $("#updatesInstallBtn").html('Installing updates, please wait..<i class="fas fa-spin fa-spinner"></i>');
        axios.get('{{ route('updates.install') }}')
        .then(function (response) {
            toastr.success(response.data.message, '@langapp('response_status')');
            $("#updatesInstallBtn").html('Update installation completed');
            location.reload();
        })
        .catch(function (error) {
            toastr.warning('Update installation failed or no updates.', '@langapp('response_status')');
            $("#updatesInstallBtn").html('Failed, Try Again');
        });
    });
</script>
@endpush
@endmod
@endsection