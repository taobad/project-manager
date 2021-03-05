@if ($company->individual == 0)
<section class="col-md-12">

    <header class="panel-heading">
        @can('users_create')
        <a href="{{  route('contacts.create', ['client' => $company->id])  }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
            @icon('solid/user-circle') @langapp('create')
        </a>
        @endcan
    </header>



    <div id="ajaxData"></div>



</section>


@endif

@push('pagestyle')
@include('stacks.css.form')
@endpush
@push('pagescript')
@include('stacks.js.form')
@endpush
@push('pagescript')
@include('clients::_scripts._contacts')
@endpush