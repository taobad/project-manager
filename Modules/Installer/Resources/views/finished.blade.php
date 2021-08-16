@extends('installer::layouts.master')
@section('content')
<section id="content" class="wrapper-md installer content">
  <div class="container aside-xxl animated fadeInUp">
    <section class="bg-white panel panel-default m-t-sm b-r-xs">
      <header class="text-center panel-heading login-heading">
        <strong>Installation Completed</strong>
      </header>
      <div class="panel-body">
        @if (session('message')['status'] === 'success')
        <div class="alert alert-success">
          <button type="button" class="close" id="close_alert" data-dismiss="alert" aria-hidden="true">
            <i class="fas fa-close" aria-hidden="true"></i>
          </button>
          <span class="text-sm">
            @icon('solid/check-circle') {{ session('message')['message'] }}
          </span>
        </div>
        @endif


        <img style="width:100%; height: 230px;" src="https://workice.s3.us-west-000.backblazeb2.com/install_success.svg" alt="">

        <p style="margin: 2rem"><strong>You're good to go! Click My Account to proceed</strong></p>
        <a href="{{ url('/') }}" class="btn btn-block btn-success">My Account</a>
      </div>
    </section>
  </div>
</section>
@endsection