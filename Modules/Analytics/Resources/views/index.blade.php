@extends('layouts.app')

@section('content')


<section id="content">
    <section class="hbox stretch">

        <section class="vbox">
            <section class="bg-indigo-100 scrollable wrapper">
                <section class="panel panel-default">

                    <header class="panel-heading">

                        @include('analytics::report_header')

                    </header>

                    <div class="panel-body">

                        @include('partial.base_currency')

                        @include('analytics::_'.$module.'.dashboard')

                    </div>

                </section>
            </section>


        </section>

    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>

@endsection

@push('pagescript')
<script>
    $(".commandBtn").click(function() {
        command = $(this).data("id");
        axios.get('{{ url('/').'/settings/artisan/'.get_option('cron_key') }}/'+command)
        .then(function (response) {
            toastr.success(response.data.message, '@langapp('response_status') ');
        })
        .catch(function (error) {
            toastr.error('Failed to execute artisan command or disabled', '@langapp('response_status') ');
        });
    });
</script>
@endpush