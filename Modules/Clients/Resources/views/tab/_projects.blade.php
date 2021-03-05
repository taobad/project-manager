<section class="col-md-12">

    <header class="panel-heading">
        @can('users_create')
        <a href="{{  route('projects.create', ['client' => $company->id])  }}" class="btn {{themeButton()}}">
            @icon('solid/clock') @langapp('create')
        </a>
        @endcan
    </header>


    <div id="ajaxData"></div>

</section>
@push('pagescript')
@include('clients::_scripts._projects')
@endpush