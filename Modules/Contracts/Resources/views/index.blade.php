@extends('layouts.app')
@section('content')
<section id="content" class="">

	<section class="vbox">
		<header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
			<div class="flex justify-between text-gray-500">
				<div>
					<div class="btn-group">
						<button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown">
							@langapp('filter')
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li>
								<a href="{{route('contracts.index', ['filter' => 'viewed'])}}">
									@langapp('viewed')
								</a>
							</li>
							<li>
								<a href="{{route('contracts.index', ['filter' => 'draft'])}}">
									@langapp('draft')
								</a>
							</li>
							<li>
								<a href="{{route('contracts.index', ['filter' => 'signed'])}}">
									@langapp('signed')
								</a>
							</li>
							<li>
								<a href="{{route('contracts.index', ['filter' => 'sent'])}}">
									@langapp('sent')
								</a>
							</li>
							<li>
								<a href="{{route('contracts.index', ['filter' => 'expired'])}}">
									@langapp('expired')
								</a>
							</li>
							<li>
								<a href="{{route('contracts.index', ['filter' => 'rejected'])}}">
									@langapp('rejected')
								</a>
							</li>
							<li>
								<a href="{{route('contracts.index')}}">@langapp('contracts') </a>
							</li>
						</ul>
					</div>

					@can('contracts_create')
					<a href="{{route('contracts.templates')}}" class="btn {{themeButton()}} ml-1" data-rel="tooltip" title="@langapp('contract') @langapp('templates')">
						@icon('solid/folder-open') @langapp('templates')
					</a>
					@endcan
				</div>
				<div>
					@can('contracts_create')
					<a href="{{route('contracts.create')}}" class="btn {{themeButton()}}">
						@icon('solid/plus') @langapp('create')
					</a>
					@endcan
				</div>
			</div>
		</header>
		<section class="bg-indigo-100 scrollable wrapper scrollpane">

			<div id="ajaxData"></div>


		</section>
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>

@push('pagescript')
@include('contracts::_scripts._contracts')
@endpush

@endsection