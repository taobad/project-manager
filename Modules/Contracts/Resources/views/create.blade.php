@extends('layouts.app')

@section('content')


<section id="content">
    <section class="hbox stretch">

        <section class="vbox">


            <header class="clearfix bg-white header b-b">
                <div class="row m-t-sm">
                    <div class="col-sm-8 m-b-xs">


                        <a href="{{ route('contracts.index') }}" class="btn {{themeButton()}}" data-toggle="tooltip" title="@langapp('contracts')  " data-placement="bottom">
                            @icon('solid/times') @langapp('cancel')
                        </a>


                    </div>
                    <div class="col-sm-4 m-b-xs">


                    </div>
                </div>
            </header>
            <section class="bg-indigo-100 scrollable wrapper">




                <div class="bg-gray-100 rounded-sm">


                    <div class="panel-body">

                        {!! Form::open(['route' => 'contracts.api.save', 'class' => 'm-b-sm ajaxifyForm']) !!}



                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>@langapp('contract_title') @required</label>
                                    <input type="text" placeholder="e.g Web Design" name="contract_title" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>@langapp('client') @required</label>
                                    <select name="client_id" class="form-control select2-option" required>
                                        @foreach (Modules\Clients\Entities\Client::select('id',
                                        'name')->where('primary_contact', '>', 0)->get() as $client)
                                        <option value="{{  $client->id  }}">{{  $client->name  }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Contract Template @required <a href="" data-toggle="tooltip"
                                            title="Choose a template from your contract templates (Menu Contracts > Templates)" data-placement="right"><i
                                                class="far fa-question-circle"></i></a></label>
                                    <select name="template_id" class="form-control">
                                        @foreach (Modules\Contracts\Entities\ContractTemplate::get() as $template)
                                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>@langapp('start_date') @required</label>

                                    <div class="input-group">

                                        <input class="datepicker-input form-control" size="16" type="text" value="{{ datePickerFormat(now()) }}" name="start_date"
                                            data-date-format="{{ get_option('date_picker_format') }}" required>
                                        <label class="input-group-addon btn" for="date">
                                            @icon('solid/calendar-alt', 'text-muted')
                                        </label>
                                    </div>


                                </div>
                                <div class="col-md-4">
                                    <label>@langapp('end_date') @required</label>
                                    <div class="input-group">
                                        <input class="datepicker-input form-control" size="16" type="text" value="{{ datePickerFormat(now()->addDays(30)) }}" name="end_date"
                                            data-date-format="{{ get_option('date_picker_format') }}" data-date-start-date="moment()" required>
                                        <label class="input-group-addon btn" for="date">
                                            @icon('solid/calendar-alt', 'text-muted')
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>@langapp('fixed_rate')</label>
                                    <select name="rate_is_fixed" class="form-control">
                                        <option value="0">@langapp('no') </option>
                                        <option value="1">@langapp('yes') </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>@langapp('fixed_price') @required </label>
                                    <input type="text" placeholder="e.g 450.00" class="form-control" name="fixed_rate">
                                </div>
                                <div class="col-md-4">
                                    <label>@langapp('hourly_rate')</label>
                                    <input type="text" placeholder="e.g 50.00" value="0" class="form-control" name="hourly_rate">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>@langapp('currency') @required</label>
                                    <select name="currency" class="form-control select2-option" required>
                                        @foreach (currencies() as $currency)
                                        <option value="{{ $currency['code'] }}" {{ $currency['code'] == get_option('default_currency') ? 'selected="selected"' : '' }}>
                                            {{ $currency['title'] }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-md-6">
                                    <label>@langapp('i_will_provide_this_service')</label>
                                    <input type="text" name="services" placeholder="e.g Web Design, Consulting, Writing" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>@langapp('who_will_own_your_work_product') <a href="" data-toggle="tooltip"
                                            title="If your work is ‘made for hire’, your client is considered the author, and owns all copyrights to the work."
                                            data-placement="right"><i class="far fa-question-circle"></i></a></label>
                                    <select name="license_owner" class="form-control">
                                        <option value="freelancer">@langapp('i_will_retain_ownership')
                                        </option>
                                        <option value="client">@langapp('made_for_hire_owned_by_client')
                                        </option>

                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>@langapp('how_long_should_client_take_to_countersign') @required </label>
                                    <input type="text" placeholder="e.g 14, 30, 90" class="form-control" name="expiry_date" required>
                                    <span class="help-block text-danger">@langapp('days').
                                        @langapp('selected_expiration_date_after_start_date')</span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>
                                        @langapp('description')
                                        <a href="" data-toggle="tooltip" title="@langapp('services_you_will_provide')" data-placement="right">
                                            <i class="far fa-question-circle"></i>
                                        </a>
                                    </label>
                                    <x-inputs.wysiwyg name="description" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">

                                    </x-inputs.wysiwyg>
                                </div>

                                <div class="col-md-6">
                                    <label>@langapp('client_granted_rights')</label>
                                    <x-inputs.wysiwyg name="client_rights" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                                        @langapp('client_rights_text')
                                    </x-inputs.wysiwyg>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>@langapp('payment_terms') @required</label>
                                    <input type="text" placeholder="e.g 14, 30, 90" class="form-control" name="payment_terms" required>
                                    <span class="help-block text-danger">Enter number of Days</span>
                                </div>
                                <div class="col-md-4">
                                    <label>@langapp('late_fee') @required</label>
                                    <input type="text" placeholder="e.g 10.00" name="late_payment_fee" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label>@langapp('late_fee_percent')</label>
                                    <select name="late_fee_percent" class="form-control">
                                        <option value="1">@langapp('yes') </option>
                                        <option value="0">@langapp('no') </option>

                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>@langapp('project_termination_period') @required</label>
                                    <input type="text" placeholder="e.g 14, 30, 90" class="form-control" name="termination_notice" required>
                                    <span class="help-block text-danger">Enter number of Days</span>
                                </div>
                                <div class="col-md-3">
                                    <label>@langapp('cancellation_fee') @required <a href="#" data-toggle="tooltip"
                                            title="If your Client terminates your contract earlier without cause, you may charge a cancellation fee, commonly known as a 'kill fee'. Note that this cannot be unreasonable or punitive. You should consult an attorney to determine if your proposed cancellation fee would be legally enforceable."
                                            data-placement="top"><i class="far fa-question-circle"></i></a></label>
                                    <input type="text" placeholder="e.g 10.00" class="form-control" name="cancelation_fee">
                                </div>
                                <div class="col-md-3">
                                    <label>@langapp('required_deposit') @required <a href="#" data-toggle="tooltip" data-placement="top"
                                            title="Getting money up front helps mitigate your risk in taking on work. We recommend that freelancers negotiate a deposit, especially for larger projects."><i
                                                class="far fa-question-circle"></i></a></label>
                                    <input type="text" placeholder="e.g 30.00" name="deposit_required" class="form-control">
                                </div>

                                <div class="col-md-3">
                                    <label>@langapp('right_to_include_in_portfolio') <a href="#" data-toggle="tooltip" data-placement="left"
                                            title="Retain right to include work attribution in your portfolio."><i class="far fa-question-circle"></i></a></label>
                                    <select name="portfolio_rights" class="form-control">
                                        <option value="1">@langapp('yes')</option>
                                        <option value="0">@langapp('no')</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>@langapp('add_noncompete') <a href="#" data-toggle="tooltip" data-placement="right"
                                            title="If enabled, remember to change the clause in Settings area">
                                            <i class="far fa-question-circle"></i></a>
                                    </label>
                                    <select name="non_compete" class="form-control">
                                        <option value="1">@langapp('yes')</option>
                                        <option value="0">@langapp('no')</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>@langapp('limit_revisions')</label>
                                    <input type="text" value="0" class="form-control" name="feedbacks" required>
                                    <span class="help-block text-danger">Default is 0 i.e no revision limits</span>
                                </div>

                                <div class="col-md-4">
                                    <label>@langapp('add_sexual_harrassment')</label>
                                    <select name="appropriate_conduct" class="form-control">
                                        <option value="1">@langapp('yes')</option>
                                        <option value="0">@langapp('no')</option>
                                    </select>
                                </div>

                            </div>
                        </div>


                        <div class="text-right">
                            {!! renderAjaxButton() !!}
                        </div>


                        {!! Form::close() !!}


                    </div>


                </div>

            </section>


        </section>



    </section>


</section>

<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>

</section>

@push('pagestyle')
<link href="//fonts.googleapis.com/css?family=Dawning+of+a+New+Day" rel="stylesheet">
@include('stacks.css.form')
@include('stacks.css.datepicker')
@include('stacks.css.wysiwyg')
@endpush

@push('pagescript')
@include('stacks.js.form')
@include('stacks.js.datepicker')
@include('stacks.js.wysiwyg')
@endpush
@endsection