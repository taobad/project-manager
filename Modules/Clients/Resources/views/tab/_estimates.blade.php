<section class="col-md-12">

    @can('estimates_create')
    <header class="panel-heading">
        <a href="{{  route('estimates.create', ['client' => $company->id])  }}" class="btn {{themeButton()}}">
            @icon('solid/file-alt') @langapp('create')
        </a>
    </header>
    @endcan

    <div id="ajaxData"></div>

</section>
@push('pagescript')
@include('clients::_scripts._estimates')
@endpush