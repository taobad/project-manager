@extends('layouts.app')
@section('content')
@php
$user = Auth::user();
@endphp
<section id="content">
  <section class="hbox stretch">
    <aside>
      <section class="bg-gray-100 vbox">

        <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
          <div class="flex justify-between text-gray-500">
            <div>
              <span class="text-xl font-semibold text-gray-600">{{ $user->name }}</span>
            </div>
            <div>
              <a href="{{ route('users.gdpr.export') }}" class="btn {{themeButton()}}">
                @icon('solid/database') GDPR Data
              </a>
              <a href="{{ route('users.api') }}" class="btn {{themeButton()}}">
                @icon('solid/code') API Settings
              </a>
              <a href="{{ route('users.2fa') }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                @icon('solid/fingerprint') 2FAuth
              </a>
            </div>
          </div>
        </header>
        <section class="scrollable wrapper bg">

          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between">
                  <div class="flex justify-between">
                    <div class="text-lg text-gray-700">Currently logged in devices</div>
                    <div>
                      <a href="{{ count($devices) > 1 ? route('logged-in-devices.logout.all') : '#' }}" class="btn {{themeButton()}} {{ count($devices) == 1 ? 'disabled' : '' }}">
                        @icon('solid/sign-out-alt') Logout all devices
                      </a>
                    </div>
                  </div>
                </div>
                <table class="table table-hover">
                  <thead class="text-gray-600">
                    <tr>
                      <th>Device</th>
                      <th>Browser</th>
                      <th>IP</th>
                      <th style="width:12%">Last Activity</th>
                      <th style="width:12%">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($devices as $device)
                    <tr>
                      <td>{{ getOs($device->user_agent) }}</td>
                      <td>{{ getBrowser($device->user_agent) }}</td>
                      <td><span class="p-1 text-white rounded-md bg-dark">{{ $device->ip_address }}</span></td>
                      <td>{{ Carbon\Carbon::parse((int)$device->last_activity)->diffForHumans() }}</td>
                      @if ($current_session_id == $device->id)
                      <td>
                        <a :disabled="true" class="btn {{themeButton()}}" disabled>
                          This Device
                        </a>
                      </td>
                      @else
                      <td>
                        <a href="/users/logout-device/{{$device->id}}" class="btn {{themeButton()}}">
                          @icon('solid/sign-out-alt') @langapp('logout')
                        </a>
                      </td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </section>
      </section>
    </aside>
  </section>
</section>
@endsection