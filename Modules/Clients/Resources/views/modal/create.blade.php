<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('new_client') </h4>
        </div>
        {!! Form::open(['route' => 'clients.api.save', 'class' => 'ajaxifyForm validator', 'novalidate' => '', 'files' => true]) !!}

        <div class="modal-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#tab-client-general" data-toggle="tab">@langapp('general') </a></li>
                <li><a href="#tab-client-address" data-toggle="tab">@langapp('address') </a></li>
                <li><a href="#tab-client-web" data-toggle="tab">@langapp('web') </a></li>
                <li><a href="#tab-client-custom" data-toggle="tab">@langapp('custom_fields') </a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab-client-general">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>@langapp('name') / @langapp('fullname') @required</label>
                            <input type="text" name="name" placeholder="ABC Company" class="input-sm form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>@langapp('email')</label>
                            <input type="email" name="email" placeholder="info@domain.com" class="input-sm form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>@langapp('contact_person') </label>
                            <input type="text" name="contact_name" placeholder="John Doe" class="input-sm form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label>@langapp('contact_email')</label>
                            <input type="text" name="contact_email" placeholder="johndoe@domain.com" class="input-sm form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>@langapp('tax_number') </label>
                            <input type="text" name="tax_number" class="input-sm form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>@langapp('phone') </label>
                            <input type="text" name="phone" class="input-sm form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>@langapp('mobile') </label>
                            <input type="text" name="mobile" class="input-sm form-control">
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>@langapp('locale') </label>
                            <select name="locale" class="form-control select2-option">
                                @foreach (languages() as $language)
                                <option value="{{ $language['code'] }}" {{ get_option('locale') == $language['code'] ? ' selected' : '' }}>{{ ucfirst($language['name']) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>@langapp('currency')</label>
                            <select name="currency" class="form-control select2-option">
                                @foreach (currencies() as $cur)
                                <option value="{{ $cur['code'] }}" {{ get_option('default_currency') == $cur['code'] ? ' selected' : '' }}>{{ $cur['native'] }} -
                                    {{ $cur['title'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@langapp('notes') </label>
                        <textarea name="notes" class="form-control ta" placeholder="@langapp('notes') "></textarea>
                    </div>

                    <div class="form-group">
                        <label>@langapp('tags') </label>
                        <select class="select2-tags form-control" name="client_tags[]" multiple="multiple">
                            @foreach (App\Entities\Tag::all() as $tag)
                            <option value="{{  $tag->name  }}">{{  $tag->name }}</option>
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
                                <input type="text" placeholder="3916 Grande Blvd" name="billing_street" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('city')</label>
                                <input type="text" placeholder="Jacksonville Beach" name="billing_city" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('state')</label>
                                <input type="text" placeholder="FL" name="billing_state" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('zipcode')</label>
                                <input type="text" placeholder="32250" name="billing_zip" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('country')</label>
                                <select class="form-control select2-option" name="billing_country">
                                    @foreach (countries() as $country)
                                    <option value="{{ $country['name'] }}" {{ $country['name'] == get_option('company_country') ? 'selected' : '' }}>
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
                                <input type="text" placeholder="3916 Grande Blvd" name="shipping_street" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('city')</label>
                                <input type="text" placeholder="Jacksonville Beach" name="shipping_city" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('state')</label>
                                <input type="text" placeholder="FL" name="shipping_state" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('zipcode')</label>
                                <input type="text" placeholder="32250" name="shipping_zip" class="input-sm form-control">
                            </div>
                            <div class="form-group">
                                <label>@langapp('country')</label>
                                <select class="form-control select2-option" name="shipping_country">
                                    @foreach (countries() as $country)
                                    <option value="{{ $country['name'] }}" {{ $country['name'] == get_option('company_country') ? 'selected' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">

                        <label>@langapp('logo') </label>
                        <input type="file" name="logo">

                    </div>

                </div>
                <div class="tab-pane fade in" id="tab-client-web">
                    <div class="form-group">
                        <label>@langapp('website') </label>
                        <input type="text" value="" name="website" class="input-sm form-control">
                    </div>
                    <div class="form-group">
                        <label>Skype</label>
                        <input type="text" value="" name="skype" class="input-sm form-control">
                    </div>
                    <div class="form-group">
                        <label>LinkedIn Username</label>
                        <input type="text" placeholder="" name="linkedin" class="input-sm form-control">
                    </div>
                    <div class="form-group">
                        <label>Facebook Username</label>
                        <input type="text" placeholder="" name="facebook" class="input-sm form-control">
                    </div>
                    <div class="form-group">
                        <label>Twitter Handle</label>
                        <input type="text" placeholder="abc_username" name="twitter" class="input-sm form-control">
                    </div>
                </div>



                <div class="tab-pane fade in" id="tab-client-custom">

                    @php
                    $data['fields'] = App\Entities\CustomField::whereModule('clients')->orderBy('order', 'desc')->get();
                    @endphp
                    @include('partial.customfields.createNoCol', $data)

                </div>
            </div>

            @include('partial.privacy_consent')

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