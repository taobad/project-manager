@extends('layouts.app')
@section('content')
<section id="content" class="bg-gray-300">
	<section class="hbox stretch">
		<aside>
			<section class="vbox">

				<header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">

					<div class="flex justify-between text-gray-500">
						<div>
							@if ($invoice->getRawOriginal('status') != 'fully_paid')
							@if(can('invoices_pay') && $invoice->balance > 0)
							<a class="btn {{themeButton()}}" data-original-title="@langapp('pay_invoice')" data-placement="bottom" data-toggle="tooltip"
								href="{{route('invoices.pay', $invoice->id)}}">
								@icon('solid/credit-card') @langapp('pay_invoice')
							</a>
							@endif
							@if($invoice->isClient())
							@include('invoices::_includes.payment_links')
							@endif
							@endif


							@can('invoices_send')
							<a href="{{ route('invoices.send', $invoice->id) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}" data-toggle="tooltip"
								title="@langapp('email') ">
								@icon('solid/envelope-open-text') @langapp('send')
							</a>
							@endcan
							@if(isAdmin() || can('invoices_update'))
							@if ($invoice->is_visible)
							<a class="btn {{themeButton()}}" href="{{ route('invoices.hide', $invoice->id) }}" data-toggle="tooltip"
								data-original-title="@langapp('hide_to_client')" data-placement="bottom">
								@icon('solid/eye-slash')
							</a>
							@else
							<a class="btn {{themeButton()}}" href="{{route('invoices.show', $invoice->id)}}" data-toggle="tooltip" data-original-title="@langapp('show_to_client')"
								data-placement="bottom">
								@icon('solid/eye')
							</a>
							@endif
							@endif

							@can('reminders_create')
							<a class="btn {{themeButton()}}" data-toggle="ajaxModal" data-toggle="tooltip" data-placement="bottom"
								href="{{route('calendar.reminder', ['module' => 'invoices', 'id' => $invoice->id])}}" title="@langapp('set_reminder')  ">
								@icon('solid/clock')
							</a>
							@endcan

							<div class="btn-group">
								<button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown">@langapp('more_actions')
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									@can('invoices_remind')
									<li>
										<a href="{{route('invoices.remind', $invoice->id) }}" data-toggle="ajaxModal" data-toggle="tooltip"
											title="@langapp('reminder')">@langapp('reminder')</a>
									</li>
									@endcan
									@can('invoices_create')
									<li>
										<a href="{{ route('invoices.copy', $invoice->id) }}" data-toggle="ajaxModal" data-toggle="tooltip"
											title="@langapp('copy')">@langapp('copy')</a>
									</li>
									@endcan
									@if ($invoice->is_recurring)
									@can('invoices_update')
									<li>
										<a href="{{ route('invoices.stop_recur', $invoice->id) }}" data-toggle="ajaxModal" data-toggle="tooltip"
											title="@langapp('stop_recurring')">@langapp('stop_recurring')</a>
									</li>
									@endcan
									@endif
									@admin
									<li>
										<a href="{{route('invoices.child', $invoice->id) }}" data-toggle="ajaxModal" data-toggle="tooltip"
											title="@langapp('children')">@langapp('children')
										</a>
									</li>
									@endadmin

									@can('invoices_update')
									@if ($invoice->isEditable())
									<li>
										<a href="{{ route('items.insert',['id' => $invoice->id, 'module' => 'invoices']) }}" title="@langapp('item_quick_add')"
											data-toggle="ajaxModal">@langapp('items')
										</a>
										@endif
									</li>

									@if ($invoice->balance > 0)
									<li>
										<a href="{{route('creditnotes.apply', ['invoice' => $invoice->id])}}" data-toggle="ajaxModal" data-toggle="tooltip"
											title="@langapp('use_credits')">@langapp('use_credits')
										</a>
									</li>
									@endif

									@endcan
									<li>
										<a href="{{route('invoices.transactions', $invoice->id)}}">
											@langapp('payments')
										</a>
									</li>
									@if (can('invoices_pay') && $invoice->balance > 0)
									<li>
										<a href="{{ route('invoices.mark_paid', $invoice->id) }}" data-toggle="ajaxModal">@langapp('mark_as_paid')
										</a>
									</li>
									@if(!$invoice->payments()->exists())
									<li>
										<a href="{{ route('invoices.cancel', $invoice->id) }}" data-toggle="ajaxModal">@langapp('cancelled')</a>
									</li>
									@endif
									@endif
									@can('invoices_send')
									<li>
										<a href="{{ route('invoices.mark.sent', $invoice->id) }}">@langapp('mark_as_sent')</a>
									</li>
									@endcan
									@can('invoices_update')
									<li>
										<a href="{{ route('invoices.edit', $invoice->id) }}" data-original-title="@langapp('make_changes') " data-toggle="tooltip"
											data-placement="bottom">@langapp('edit')
										</a>
									</li>
									@endcan
									@can('invoices_delete')
									<li>
										<a href="{{ route('invoices.delete', $invoice->id) }}" title="@langapp('delete')" data-toggle="tooltip"
											data-toggle="ajaxModal">@langapp('delete')</a>
									</li>
									@endcan
								</ul>
							</div>

						</div>

						<div>
							@admin
							@if($invoice->company->primary_contact)
							<a class="btn {{themeButton()}}" data-placement="bottom" data-toggle="tooltip"
								href="{{ route('users.impersonate', ['id' => $invoice->company->contact->id ]) }}" title="@langapp('client') @langapp('view')">
								@icon('solid/user-secret') @langapp('as_client')
							</a>
							@endif
							@endadmin
							<a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn {{themeButton()}}">
								@icon('solid/file-invoice-dollar') PDF
							</a>
							@can('invoices_update')
							<a href="{{route('invoices.share', $invoice->id)}}" data-rel="tooltip" title="Share Invoice" class="btn {{themeButton()}}" data-toggle="ajaxModal">
								@icon('solid/share-alt')
							</a>
							@endcan

							<a href="#aside-settings" data-toggle="class:show" class="btn {{themeButton()}}">@icon('regular/folder-open')</a>
						</div>
					</div>
				</header>


				<section class="p-4 scrollable ie-details">

					@php
					$due = $invoice->due();
					@endphp


					<div class="p-4 bg-white rounded-sm col-md-12">

						<div class="ribbon {{$invoice->ribbonColor()}}"><span>{{$invoice->status}}</span></div>


						@if (is_null($invoice->cancelled_at))
						@if ($invoice->isOverdue())
						<x-alert type="danger" icon="solid/exclamation-triangle" class="text-sm leading-5">
							@langapp('invoice_overdue', ['date' => $invoice->due_date->toDayDateTimeString()])
						</x-alert>
						@endif

						@else
						<x-alert type="warning" icon="solid/exclamation-circle" class="text-sm leading-5">
							@langapp('invoice_cancelled')
						</x-alert>
						@endif
						@if ($invoice->isClient() && $invoice->gocardlessMandates->count())
						<x-alert type="success" icon="solid/info-circle" class="text-sm leading-5">
							You have already setup Gocardless Direct Debit mandate for this invoice, we will attempt to auto-bill the invoice. This may take a few days.
						</x-alert>
						@endif
						@if (can('invoices_view_all') && $invoice->company->creditBalance() > 0)
						<div class="px-2 py-3 mb-2 bg-teal-100 border-b border-teal-500">
							<span class="font-bold"> Credits Available: </span>
							A credit of <span class="font-bold">
								{{ formatCurrency($invoice->company->currency, $invoice->company->creditBalance()) }}</span>
							available for this customer.
							Click <strong>More</strong> button to use these credits.
						</div>
						@endif
						<div class="mt-4 row">
							<div class="col-md-6 col-xs-12">
								<div style="height: {{ get_option('invoice_logo_height') }}px">
									<img class="ie-logo with-responsive-img" src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('invoice_logo'))}}">
								</div>
							</div>
							<div class="text-right text-gray-600 col-md-6 col-xs-12">
								<p class="h4">
									<span class="text-3xl font-semibold">{{ $invoice->reference_no }}</span>
									<span class="text-muted">
										{!! $invoice->isDraft() ? '<span class="label label-danger">'.langapp('draft').'</span>' : '' !!}
									</span>
									@if ($invoice->is_recurring)
									<span class="label bg-danger">
										@icon('solid/sync-alt', 'fa-spin') {{ $invoice->recur_frequency }} </span>
									@endif
								</p>
								<div class="py-1">
									@langapp('invoice_date')
									<span class="col-xs-4 no-gutter-right pull-right">
										<strong>
											{{ dateString($invoice->created_at) }}
										</strong>
									</span>
								</div>
								@if ($invoice->is_recurring)
								<div class="py-1">
									@langapp('recur_next_date')
									<span class="col-xs-4 no-gutter-right pull-right">
										<strong>
											{{ dateTimeString($invoice->recurring->next_recur_date) }}
										</strong>
									</span>
								</div>
								@endif
								<div class="py-1">
									@langapp('payment_due')
									<span class="col-xs-4 no-gutter-right pull-right">
										<strong>
											{{ dateString($invoice->due_date) }}
										</strong>
									</span>
								</div>
								<div class="py-1">
									@langapp('status')
									<span class="col-xs-4 no-gutter-right pull-right">
										<span class="label label-success">
											{{ $invoice->status }}
										</span>
									</span>
								</div>
								@if(isAdmin() && $invoice->viewed_at != null)
								<div class="py-1">
									@langapp('viewed')
									<span class="col-xs-4 no-gutter-right pull-right">
										<span class="label label-success">
											{{ dateElapsed($invoice->viewed_at) }}
										</span>
									</span>
								</div>
								@endif
								@if($invoice->currency != get_option('default_currency'))
								<div class="py-1">
									@langapp('xrate')
									<span class="col-xs-4 no-gutter-right pull-right">
										<strong>
											1 {{ $invoice->currency }} = {{ get_option('default_currency') }}
											{{ round(convertCurrency($invoice->currency, 1, get_option('default_currency')), 4) }}
										</strong>
									</span>
								</div>
								@endif
								@if($invoice->project_id > 0 && isAdmin())
								<div class="py-1">
									@langapp('project')
									<span class="col-xs-4 no-gutter-right pull-right">
										<a class="text-indigo-600" href="{{ route('projects.view', ['project' => $invoice->project_id, 'tab' => 'invoices']) }}">
											<strong>{{ $invoice->project->name }}</strong>
										</a>
									</span>
								</div>
								@endif
							</div>
						</div>
						@php
						$data['company'] = $invoice->company;
						$address_span = $invoice->show_shipping_on_invoice == 1 ? 4 : 6;
						@endphp
						<div class="p-4 mt-2 mb-3 bg-gray-100 border rounded-lg">
							<div class="row">
								@if (get_option('swap_to_from') == 'FALSE')
								<div class="col-xs-{{$address_span}}">
									<strong>@langapp('received_from'):</strong>
									<address>
										{!! formatCompanyAddress($data) !!}
									</address>
									@if(get_option('contact_person'))
									<address>
										<strong>@langapp('contact_person') </strong><br>
										<a class="text-indigo-600" href="mailto:{{ get_option('company_email') }}">{{ get_option('contact_person') }}</a>
									</address>
									@endif
								</div>
								@endif
								{{-- / SWAP FROM ADDRESS --}}

								<div class="col-xs-{{$address_span}}">
									<strong>@langapp('bill_to'):</strong>
									<div class="pmd-card-body">
										<address>
											{!! formatClientAddress($invoice, 'invoice', 'billing', true) !!}
										</address>
										@if($invoice->company->primary_contact)
										<address>
											<strong>@langapp('contact_person') </strong><br>
											<a class="text-indigo-600" href="mailto:{{ $invoice->company->contact->email }}">{{ $invoice->company->contact->name }}</a>
										</address>
										@endif
									</div>

									@can('invoices_update')
									@if ($invoice->company->unbilledExpenses() > 0 && $invoice->isEditable())
									<span class="text-info hidden-print">
										<a href="{{route('items.expenses', $invoice->id)}}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
											@langapp('expenses_available')
										</a>
									</span>
									@endif
									@endcan
								</div>
								@if (get_option('swap_to_from') == 'TRUE')
								<div class="col-xs-{{$address_span}}">
									<strong>@langapp('received_from'):</strong>
									<address>
										{!! formatCompanyAddress($data) !!}
									</address>
									@if(get_option('contact_person'))
									<address>
										<strong>@langapp('contact_person') </strong><br>
										<a class="text-indigo-600" href="mailto:{{ get_option('company_email') }}">{{ get_option('contact_person') }}</a>
									</address>
									@endif
								</div>
								@endif
								@if($invoice->show_shipping_on_invoice == 1)
								<div class="col-xs-{{$address_span}}">
									<strong>Ship To:</strong>
									<address>
										{!! formatClientAddress($invoice, 'invoice', 'shipping') !!}
									</address>
								</div>
								@endif
							</div>
						</div>
						@php
						$showtax = $invoice->tax_per_item == 1 ? true :false;
						$showDiscount = $invoice->discount_per_item == 1 ? true :false;
						@endphp
						<div class="line"></div>
						<div class="table-responsive">
							{!! Form::open(['url' => '#', 'class' => 'bs-example form-horizontal', 'id' =>
							'saveItem']) !!}
							<table id="inv-details" class="table sorted_table" type="invoices">
								<thead>
									<tr class="uppercase bg-indigo-200">
										<th></th>
										<th style="width:20%">@langapp('product')</th>
										<th style="width:25%" class="hidden-xs">@langapp('description')</th>
										<th class="text-right">@langapp('qty')</th>
										@if ($showtax)
										<th style="width:15%" class="text-right">@langapp('tax_rate')</th>
										@endif
										<th class="text-right">{{ itemUnit() }}</th>
										@if ($showDiscount)
										<th style="width:10%" class="text-right">@langapp('disc')</th>
										@endif
										<th style="width:10%" class="text-right">@langapp('total')</th>
										<th class="text-right inv-actions"></th>
									</tr>
								</thead>
								<tbody>
									@foreach ($invoice->items as $key => $item)
									<tr class="sortable" data-id="{{$item->id}}" id="item-{{ $item->id }}">
										<td class="drag-handle">
											@icon('solid/bars')
										</td>
										<td class="{{themeLinks('font-semibold')}}">
											@if(can('invoices_update') && $invoice->isEditable())
											<a href="{{route('items.edit', $item->id)}}" data-toggle="ajaxModal">
												{{ $item->name == '' ? '...' : $item->name }}
											</a>
											@else {{ $item->name }} @endif
										</td>
										<td class="text-gray-600 hidden-xs">@parsedown($item->description)</td>
										<td class="text-right">{{ formatQuantity($item->quantity) }}</td>
										@if ($showtax)
										<td class="text-right">
											{{ $item->tax_total }}</td>
										@endif
										<td class="text-right">{{ formatDecimal($item->unit_cost) }}</td>
										@if ($showDiscount)
										<td class="text-right text-dark">{{ $item->discount }}%</td>
										@endif
										<td class="font-semibold text-right text-gray-600">
											{{ formatCurrency($invoice->currency, $item->total_cost) }}</td>
										<td class="text-right">
											@if(can('invoices_update') && $invoice->isEditable())
											<a class="hidden-print deleteItem" href="#" data-item-id="{{ $item->id }}">
												@icon('regular/trash-alt', 'text-danger')
											</a>
											@endif
										</td>
									</tr>
									@endforeach
									@can('invoices_update')

									@if ($invoice->isEditable())
									@widget('Items\CreateItemWidget', ['module_id' => $invoice->id, 'module' =>
									'invoices', 'order' => count($invoice->items) + 1, 'taxes' => $showtax,'discount' => $showDiscount])
									@endif

									@endcan
									<tr>
										<td class="text-right totalsColspan no-border">
											<strong>@langapp('sub_total')</strong>
										</td>
										<td class="text-right">
											<span id="subtotal">
												{{ formatCurrency($invoice->currency, $invoice->subTotal()) }}
											</span>
										</td>
										<td></td>
									</tr>

									@if ($invoice->discount > 0)
									<tr>
										<td class="text-right totalsColspan no-border">
											<strong>@langapp('discount') - {{ formatTax($invoice->discount) }}
												{{ ($invoice->discount_percent) ? '%' : '' }}</strong>
										</td>
										<td class="text-right">
											<span id="discount">
												{{ formatCurrency($invoice->currency, $invoice->discounted()) }}
											</span>
										</td>
										<td></td>
									</tr>
									@endif

									@foreach ($invoice->taxes->groupBy('tax_type_id') as $taxes)
									<tr class="taxes">
										<td class="text-right no-border totalsColspan">
											<strong>{{ $taxes[0]->taxtype->name }}
												({{ formatTax($taxes[0]->percent) }}%)</strong>
										</td>
										<td class="text-right">
											<span id="tax-{{$taxes[0]->id}}">
												{{ formatCurrency($invoice->currency, $invoice->taxTypeAmount($taxes)) }}
											</span>
										</td>
										<td></td>
									</tr>
									@endforeach


									@if ($invoice->tax != 0)
									<tr>
										<td class="text-right no-border totalsColspan">
											<strong>{{ get_option('tax1Label') }}
												({{ formatTax($invoice->tax) }}%)</strong>
										</td>
										<td class="text-right">
											<span id="tax1">
												{{ formatCurrency($invoice->currency, $invoice->tax1Amount()) }}
											</span>
										</td>
										<td></td>
									</tr>
									@endif
									@if ($invoice->tax2 != 0)
									<tr>
										<td class="text-right no-border totalsColspan">
											<strong>{{ get_option('tax2Label') }}
												({{ formatTax($invoice->tax2) }}%)</strong>
										</td>
										<td class="text-right">
											<span id="tax2">
												{{ formatCurrency($invoice->currency, $invoice->tax2Amount()) }}
											</span>
										</td>
										<td></td>
									</tr>
									@endif
									@if ($invoice->lateFee() > 0)
									<tr>
										<td class="text-right no-border totalsColspan">
											<strong>@langapp('late_fee')</strong>
										</td>
										<td class="text-right">
											<span id="discount">
												{{ formatCurrency($invoice->currency, $invoice->lateFee()) }}
											</span>
										</td>
										<td></td>
									</tr>
									@endif

									@if ($invoice->extra_fee > 0)
									<tr>
										<td class="text-right no-border totalsColspan">
											<strong>@langapp('extra_fee') +
												{{ $invoice->extra_fee }}{{ ($invoice->fee_is_percent) ? '%' : '' }}</strong>
										</td>
										<td class="text-right">
											<span id="fee">
												{{ formatCurrency($invoice->currency, $invoice->extraFee()) }}
											</span>
										</td>
										<td></td>
									</tr>
									@endif

									@if ($invoice->paid() > 0)
									<tr>
										<td class="text-right no-border totalsColspan">
											<strong>@langapp('payment_made')</strong>
										</td>
										<td class="text-right text-danger">(-)<span id="paid">
												{{ formatCurrency($invoice->currency, $invoice->paid()) }}
											</span>
										</td>
										<td></td>
									</tr>
									@endif

									@if ($invoice->creditedAmount() > 0)
									<tr>
										<td class="text-right no-border totalsColspan">
											<strong>@langapp('credits_applied')</strong>
										</td>
										<td class="text-right text-danger">
											(-)
											<span id="credits">
												{{ formatCurrency($invoice->currency, $invoice->creditedAmount()) }}
											</span>
										</td>
										<td></td>
									</tr>
									@endif
									<tr class="bg-indigo-200">
										<td class="text-right no-border totalsColspan">
											<strong>
												@langapp('balance')</strong>
										</td>
										<td class="font-semibold text-right">
											<span id="invoiceDue">
												{{ formatCurrency($invoice->currency, $due) }}
											</span>
										</td>
										<td></td>
									</tr>
								</tbody>
							</table>
							{!! Form::close() !!}

						</div>
						@if ($invoice->late_fee > 0 && !$invoice->isOverdue())
						<p class="text-danger">Late fee of
							{{ $invoice->late_fee_percent === 0 ? $invoice->currency : '' }}
							{{ $invoice->late_fee }} {{ $invoice->late_fee_percent ? '%' : '' }} will be applied.
						</p>
						@endif
						@if (settingEnabled('amount_in_words'))
						@widget('Payments\AmountWords', [
						'currency' => $invoice->currency, 'amount' => $due
						])
						@endif

						<div class="line line-dashed"></div>

						@if ($invoice->gatewayEnabled('bank'))
						<div class="mt-1 text-sm prose-lg">
							<h4 class="font-bold uppercase">@langapp('bank_details')</h4>
							<div class="py-1 ml-3 font-semibold text-gray-600">
								@parsedown(get_option('bank_details'))
							</div>
						</div>

						@endif

						<div class="mt-1 text-sm prose-lg notes-section">
							<h4 class="font-semibold text-gray-700 uppercase">@langapp('notes')</h4>
							@parsedown(str_replace('{REMAINING_DAYS}', $invoice->dueDays().' days', $invoice->notes))
						</div>

						<div class="py-2">
							@widget('CustomFields\Extras', ['custom' => $invoice->custom])
						</div>


						@if (count($invoice->installments) > 1)
						<div>
							<h4>@langapp('installments')</h4>
							<table class="table table-responsive table-hover">
								<thead>
									<tr>
										<th>@langapp('amount')</th>
										<th>@langapp('due_date')</th>
										<th>@langapp('description')</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($invoice->installments as $partial)
									<tr class="">
										<td>
											@if ($partial->balance() <=0 ) @icon('solid/check-square', 'text-success' ) @endif @php $partial_total=$invoice->payable *
												($partial->percentage /
												100);
												@endphp
												{{ formatCurrency($invoice->currency, $partial_total) }}
												({{ $partial->percentage }}%) bal.
												<span class="text-muted">
													{{ formatCurrency($invoice->currency, $partial->balance()) }}</span>
										</td>
										<td class="text-muted">{{ dateFormatted($partial->due_date) }}</td>
										<td>{{ $partial->notes }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						@endif
						{{--  CREDITS APPLIED  --}}
						@if ($invoice->credited()->exists())
						<h4 class="py-3 font-bold uppercase">@langapp('credits_applied')</h4>
						<table class="table">
							<tbody>
								<tr class="text-muted">
									<td>@langapp('date')</td>
									<td>@langapp('credit_note')#</td>
									<td>@langapp('credits_applied')</td>
									<td></td>
								</tr>
								@foreach ($invoice->credited as $credited)
								<tr>
									<td>{{ dateFormatted($credited->created_at) }}</td>
									<td class="{{themeLinks('font-semibold')}}">
										<a href="{{ route('creditnotes.view', $credited->creditnote_id) }}" class="">{{ $credited->credit->reference_no }} </a>
									</td>
									<td>
										{{ formatCurrency($credited->credit->currency, $credited->credited_amount) }}
									</td>
									<td>
										@can('credits_update')
										<a href="{{ route('creditnotes.remove_credit', $credited->id) }}" data-toggle="ajaxModal">
											@icon('regular/trash-alt','text-indigo-600')
										</a>
										@endcan
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						@endif

						{{ $invoice->clientViewed() }}

						<div x-data="{ tab: 'activities' }">
							<div class="">
								<nav class="flex flex-col sm:flex-row">
									<a href="#" :class="{ '{{themeLinks('border-b-2 border-indigo-500')}}': tab === 'activities' }" @click="tab = 'activities'"
										class="block px-6 py-4 text-gray-600 text-semibold focus:outline-none">
										<i class="fas fa-history"></i> @langapp('activities')
									</a>
									<a href="#" :class="{ '{{themeLinks('border-b-2 border-indigo-500')}}': tab === 'comments' }" @click="tab = 'comments'"
										class="block px-6 py-4 text-gray-600 text-semibold hover:text-indigo-500 focus:outline-none">
										<i class="fas fa-comments"></i> @langapp('comments')
									</a>

								</nav>
							</div>

							<div class="py-2 bg-gray-100 rounded">

								<div x-show="tab === 'activities'" class="py-1">
									<div class="comments-history">
										@canany(['invoices_create', 'invoices_update'])
										@livewire('common.activities',['activities' => $invoice->activities])
										@endcanany
									</div>
								</div>
								<div x-show="tab === 'comments'" class="py-1">

									<section class="block comment-list">
										@can('invoices_comment')
										<article class="comment-item" id="comment-form">
											<a class="pull-left thumb-sm avatar">
												<img src="{{ avatar() }}" class="img-circle">
											</a>
											<span class="arrow left"></span>
											<section class="comment-body">
												<section class="p-2 panel panel-default">
													@widget('Comments\CreateWidget', ['commentable_type' => 'invoices' , 'commentable_id' => $invoice->id])
												</section>
											</section>
										</article>

										@widget('Comments\ShowComments', ['comments' => $invoice->comments])
										@endcan
									</section>

								</div>

							</div>


						</div>

					</div>
				</section>
			</section>

		</aside>

		<aside class="bg-white aside-lg b-l hide" id="aside-settings">
			<header class="p-2 border-b">
				<div class="flex justify-between">
					<div>
						<span class="text-lg text-gray-600">
							@langapp('files')
						</span>
					</div>
					<div>
						@can('files_create')
						<a href="{{route('files.upload', ['module' => 'invoices', 'id' => $invoice->id])}}" title="@langapp('upload_file')" data-toggle="ajaxModal"
							class="btn {{themeButton()}}">
							@icon('solid/upload')
						</a>
						@endcan
					</div>
				</div>
			</header>
			<div class="m-1">
				@include('partial._show_files', ['files' => $invoice->files, 'limit' => true])
			</div>
		</aside>
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
	@push('pagestyle')
	<link href="{{ getAsset('plugins/typeahead/typeahead.css') }}" rel="stylesheet" type="text/css">
	@include('stacks.css.form')
	@include('stacks.css.wysiwyg')
	@endpush
	@push('pagescript')
	@cannot('invoices_pay')
	@if ($invoice->gatewayEnabled('braintree'))
	<script src="https://js.braintreegateway.com/web/dropin/1.25.0/js/dropin.min.js"></script>
	@endif
	@if ($invoice->gatewayEnabled('stripe') && $invoice->isClient())
	<script src='https://js.stripe.com/v3/' type='text/javascript'></script>
	@endif
	@if($invoice->gatewayEnabled('square'))
	@php
	$squarejs = config('services.square.sandbox')
	? 'https://js.squareupsandbox.com/v2/paymentform'
	: 'https://js.squareup.com/v2/paymentform';
	@endphp
	<script type="text/javascript" src="{{$squarejs}}"></script>
	@endif
	@if ($invoice->gatewayEnabled('checkout'))
	<script type="text/javascript" src="https://2pay-js.2checkout.com/v1/2pay.js"></script>
	@endif
	@endcannot
	<script src="{{ getAsset('plugins/typeahead/typeahead.jquery.min.js') }}"></script>
	@include('stacks.js.typeahead')
	@include('stacks.js.form')
	@include('stacks.js.sortable')
	@include('stacks.js.wysiwyg')
	@include('comments::_ajax.ajaxify')
	@include('invoices::_includes.items_ajax')

	<script>
		$(".totalsColspan").attr('colspan',document.getElementById('inv-details').rows[0].cells.length - 2);
		$('#tabs').on('click','.tablink,#prodTabs a',function (e) {
		e.preventDefault();
		var url = $(this).attr("data-url");
		if (typeof url !== "undefined") {
			var pane = $(this), href = this.hash;
		$(href).load(url,function(result){
			pane.tab('show');
		});
		} else {
			$(this).tab('show');
		}
    });
	</script>

	@endpush
</section>
@endsection