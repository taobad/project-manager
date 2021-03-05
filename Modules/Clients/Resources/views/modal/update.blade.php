<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('make_changes') - {{ $client->name }}</h4>
        </div>
        {!! Form::open(['route' => ['clients.api.update', 'id' => $client->id], 'class' => 'ajaxifyForm validator', 'novalidate' => '', 'method' => 'PUT', 'files' => true]) !!}

        <input type="hidden" name="id" value="{{  $client->id  }}">

        <div class="modal-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#tab-client-general" data-toggle="tab">@langapp('general') </a></li>
                <li><a href="#tab-client-address" data-toggle="tab">@langapp('address') </a></li>
                <li><a href="#tab-client-web" data-toggle="tab">@langapp('web') </a></li>
                <li><a href="#tab-client-custom" data-toggle="tab">@langapp('custom_fields') </a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab-client-general">

                    <input type="hidden" name="code" value="{{ $client->code }}">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>@langapp('name') / @langapp('fullname') @required</label>
                            <input type="text" name="name" value="{{ $client->name }}" class="input-sm form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>@langapp('email')</label>
                            <input type="email" name="email" value="{{ $client->email }}" class="input-sm form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>@langapp('tax_number') </label>
                            <input type="text" name="tax_number" value="{{ $client->tax_number }}" class="input-sm form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>@langapp('phone') </label>
                            <input type="text" value="{{ $client->phone }}" name="phone" class="input-sm form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>@langapp('mobile') </label>
                            <input type="text" value="{{ $client->mobile }}" name="mobile" class="input-sm form-control">
                        </div>
                        <div class="clearfix"></div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>@langapp('locale') </label>
                            <select name="locale" class="form-control select2-option">
                                @foreach (locales() as $locale)
                                <option value="{{ $locale['code'] }}" {{ $client->locale == $locale['code'] ? ' selected' : '' }}>{{ ucfirst($locale['language']) }} -
                                    {{ $locale['code'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>@langapp('currency')</label>
                            <select name="currency" class="form-control select2-option">
                                @foreach (currencies() as $cur)
                                <option value="{{  $cur['code']  }}" {{ $client->currency == $cur['code'] ? ' selected' : '' }}>{{ $cur['native'] }} - {{ $cur['title'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@langapp('notes') </label>
                        <textarea name="notes" class="form-control ta"> {{ $client->notes }} </textarea>
                    </div>

                    <div class="form-group">
                        <label>@langapp('tags') </label>
                        <select class="select2-tags form-control" name="client_tags[]" multiple>
                            @foreach (App\Entities\Tag::all() as $tag)
                            <option value="{{ $tag->name  }}" {{ in_array($tag->id, array_pluck($client->tags->toArray(), 'id')) ? ' selected="selected"' : '' }}>
                                {{ $tag->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="tab-pane fade in" id="tab-client-address">

                    <div class="flex justify-between text-gray-600">
                        <div class="col-md-6 no-gutter-left">
                            <h2 class="mb-2 text-lg font-semibold">@langapp('billing_address')</h2>
                            <div class="form-group">
                                <label>@langapp('address')</label>
                                <input type="text" value="{{ $client->billing_street }}" name="billing_street" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('city')</label>
                                <input type="text" value="{{ $client->billing_city }}" name="billing_city" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('state')</label>
                                <input type="text" value="{{ $client->billing_state }}" name="billing_state" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('zipcode')</label>
                                <input type="text" value="{{ $client->billing_zip }}" name="billing_zip" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('country')</label>
                                <select class="form-control select2-option" name="billing_country">
                                    @foreach (countries() as $country)
                                    <option value="{{ $country['name'] }}" {{ $country['name'] == $client->billing_country ? 'selected="selected"' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 no-gutter-right">
                            <h2 class="mb-2 text-lg font-semibold">@langapp('shipping_address')</h2>
                            <div class="form-group">
                                <label>@langapp('address')</label>
                                <input type="text" value="{{ $client->shipping_street }}" name="shipping_street" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('city')</label>
                                <input type="text" value="{{ $client->shipping_city }}" name="shipping_city" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('state')</label>
                                <input type="text" value="{{ $client->shipping_state }}" name="shipping_state" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('zipcode')</label>
                                <input type="text" value="{{ $client->shipping_zip }}" name="shipping_zip" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('country')</label>
                                <select class="form-control select2-option" name="shipping_country">
                                    @foreach (countries() as $country)
                                    <option value="{{ $country['name'] }}" {{ $country['name'] == $client->shipping_country ? 'selected="selected"' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="thumb-sm avatar pull-right">
                            <img src="{{ $client->logo }}" width="50" class="img-circle m-sm">
                        </span>
                        <label>@langapp('logo') </label>
                        <input type="file" name="logo">
                    </div>

                    <div class="mt-1 form-check">
                        <label>
                            <input type="checkbox" name="update_invoices_addresses" value="1">
                            <span class="{{themeText('font-semibold')}} label-text" data-toggle="tooltip"
                                title="Update billing/shipping addresses for previous invoices/estimates">@langapp('update_previous_addresses_invoices')</span>
                        </label>
                    </div>
                    <div class="mt-1 form-check">
                        <label>
                            <input type="checkbox" name="update_credits_addresses" value="1">
                            <span class="{{themeText('font-semibold')}} label-text">@langapp('update_credits_addresses')</span>
                        </label>
                    </div>

                </div>
                <div class="tab-pane fade in" id="tab-client-web">
                    <div class="form-group">
                        <label>@langapp('website') </label>
                        <input type="text" value="{{ $client->website }}" name="website" class="input-sm form-control">
                    </div>
                    <div class="form-group">
                        <label>Skype</label>
                        <input type="text" value="{{ $client->skype }}" name="skype" class="input-sm form-control">
                    </div>
                    <div class="form-group">
                        <label>LinkedIn Username</label>
                        <input type="text" value="{{ $client->linkedin }}" name="linkedin" class="input-sm form-control">
                    </div>
                    <div class="form-group">
                        <label>Facebook Username</label>
                        <input type="text" value="{{ $client->facebook }}" name="facebook" class="input-sm form-control">
                    </div>
                    <div class="form-group">
                        <label>Twitter Handle</label>
                        <input type="text" value="{{ $client->twitter }}" name="twitter" class="input-sm form-control">
                    </div>
                </div>




                {{-- custom fields --}}
                <div class="tab-pane fade in" id="tab-client-custom">

                    @php
                    $data['fields'] = App\Entities\CustomField::whereModule('clients')->orderBy('order', 'desc')->get();
                    @endphp
                    @include('clients::_includes.updateCustom', $data)

                </div>
                {{-- /custom fields --}}
            </div>
            <div class="modal-footer">
                {!! closeModalButton() !!}
                {!! renderAjaxButton() !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @push('pagestyle')
    @include('stacks.css.form')
    @endpush
    @push('pagescript')
    @include('stacks.js.form')
    @include('partial.ajaxify')
    @endpush

    @stack('pagestyle')
    @stack('pagescript')