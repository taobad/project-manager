@extends('layouts.public')
@section('content')

<section id="content" class="details-page public-page">
	<div class="container clearfix details-container bg">
		<section class="vbox">
			<header class="header b-b b-light hidden-print">


				<p class="h3">@langapp('appointment') {{ $appointment->name }}</p>

				<a href="{{  route('calendar.appointments')  }}" class="btn {{themeButton()}} pull-right">@icon('solid/home') @langapp('dashboard')
				</a>


			</header>
			<section class="wrapper panel-default">
				<div class="panel-body">
					<div class="m-xs">
						<span class="text-gray-600">@langapp('name') : </span>
						<span class="text-bold">{{ $appointment->name }}</span>
					</div>
					<div class="m-xs">
						<span class="text-gray-600">@langapp('venue') : </span>
						<span class="text-bold">{{ $appointment->venue }}</span>
					</div>
					@if($appointment->lead_id)
					<div class="m-xs">
						<span class="text-gray-600">@langapp('lead') : </span>
						<span class="text-bold">{{ $appointment->lead->name }}</span>
					</div>
					@endif
					<div class="m-xs">
						<span class="text-gray-600">@langapp('timezone') : </span>
						<span class="text-bold">{{ $appointment->timezone }}</span>
					</div>
					<div class="m-xs">
						<span class="text-gray-600">@langapp('start_date') : </span>
						<span class="text-bold">{{ dateTimeFormatted($appointment->start_time) }}</span>
					</div>
					<div class="m-xs">
						<span class="text-gray-600">@langapp('end_date') : </span>
						<span class="text-bold">{{ dateTimeFormatted($appointment->finish_time) }}</span>
					</div>
					<div class="m-xs">
						<span class="text-gray-600">@langapp('user') : </span>
						<span class="text-bold">{{ $appointment->user->name }}</span>
					</div>
					<div class="m-xs">
						<span class="text-gray-600">@langapp('alert') : </span>
						<span class="text-bold">{{ $appointment->alert }} minutes before event</span>
					</div>
					<div class="m-xs">
						<span class="text-gray-600">@langapp('status') : </span>
						<span class="text-bold">{{ $appointment->status }}</span>
					</div>
					<div class="m-xs">
						<a class="thumb-sm avatar" data-toggle="tooltip" title="{{ $appointment->attendee->name }}">
							<img src="{{ $appointment->attendee->profile->photo}}" class="img-rounded">
						</a>
					</div>
					<div class="m-xs">
						<blockquote class="text-sm text-gray-600">
							@parsedown($appointment->comments)
						</blockquote>
					</div>
				</div>
			</section>
		</section>
		<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
	</div>
</section>
@endsection