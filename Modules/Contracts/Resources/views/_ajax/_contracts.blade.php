<div class="row">
	@php $counter = 0; @endphp
	@foreach ($contracts as $key => $contract)
	@if (!(($counter++) % 2))
</div>
<div class="row">
	@endif
	<div class="col-md-6">
		<div class="panel invoice-grid widget-b">
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<h3 class="text-ellipsis">
							<a href="{{route('contracts.view', ['contract' => $contract->id])}}" class="{{themeLinks('text-lg font-semibold')}}">
								{{ $contract->contract_title }}
							</a>
						</h3>
						<ul class="list list-unstyled">
							<li>
								<a class="{{themeLinks('font-semibold')}}" href="{{route('clients.view', ['client' => $contract->client_id])}}">
									{{ optional($contract->company)->name }}
								</a>
							</li>
							<li>@langapp('start_date') :
								<span class="">
									{{ dateFormatted($contract->start_date) }}
								</span>
							</li>
							<li>Template :
								<span class="text-bold">
									{{ str_limit($contract->template->name, 20) }}
								</span>
							</li>
						</ul>
					</div>
					<div class="col-sm-6">
						@if ($contract->rate_is_fixed == '1')
						@php
						$rate = formatCurrency($contract->currency, $contract->fixed_rate);
						@endphp
						@else
						@php
						$rate = formatCurrency($contract->currency, $contract->hourly_rate).'/hr';
						@endphp
						@endif
						<h4 class="text-xl font-semibold text-right text-gray-600">{{ $rate }}</h4>
						<ul class="text-right list list-unstyled">
							<li>@langapp('signed'):
								<span class="text-success">
									{{ ($contract->signed == '1') ? langapp('yes') : langapp('no') }}</span>
							</li>
							<li>@langapp('status'):
								<span class="label label-danger">{{ $contract->status }}</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="panel-footer panel-footer-condensed">
				<a class="heading-elements-toggle"></a>
				<div class="heading-elements">
					<span class="heading-text">
						<span class="status-mark border-danger position-left"></span> @langapp('due_date') :
						<span class="font-semibold text-gray-700">{{ dateFormatted($contract->expiry_date) }}</span>
					</span>
					<div class="btn-group btn-group-animated pull-right">
						<button type="button" class="btn {{themeButton()}} dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							@icon('solid/ellipsis-h')
						</button>
						<ul class="dropdown-menu">
							<li>
								<a href="{{route('contracts.download', $contract->id)}}">
									@icon('solid/file-pdf') PDF
								</a>
							</li>

							@can('contracts_sign')
							@if ($contract->signed == '0')
							<li>
								<a href="{{ route('contracts.send', $contract->id)}}" data-toggle="ajaxModal">
									@icon('solid/paper-plane') @langapp('sign_send')
								</a>
							</li>
							@endif

							@can('contract_update')
							<li>
								<a href="{{ route('contracts.share', $contract->id) }}" data-toggle="ajaxModal">
									@icon('solid/link') @langapp('share')
								</a>
							</li>
							@endcan

							@endcan

							@can('contracts_create')
							<li>
								<a href="{{route('contracts.copy', $contract->id)}}" data-toggle="ajaxModal">
									@icon('solid/copy') @langapp('copy')
								</a>
							</li>
							@endcan

							@if (!is_null($contract->sent_at))
							<li>
								<a href="{{route('contracts.remind', $contract->id)}}" data-toggle="ajaxModal">
									@icon('solid/history') @langapp('reminder')
								</a>
							</li>
							@endif

							@can('contracts_update')
							<li>
								<a href="{{route('contracts.edit', $contract->id)}}">
									@icon('solid/pencil-alt') @langapp('make_changes')
								</a>
							</li>
							@endcan
							@can('contracts_delete')
							<li>
								<a href="{{route('contracts.delete', $contract->id)}}" data-toggle="ajaxModal">
									@icon('solid/trash-alt') @langapp('delete')
								</a>
							</li>
							@endcan

						</ul>
					</div>


				</div>
			</div>
		</div>
	</div>
	@endforeach
</div>