<section class="col-md-12">
	@can('credits_create')
	<header class="panel-heading">
		<a href="{{  route('creditnotes.create', ['client' => $company->id])  }}" class="btn {{themeButton()}}">
			@icon('solid/receipt') @langapp('create')
		</a>
	</header>
	@endcan
	<div id="ajaxData"></div>

</section>

@push('pagestyle')
@include('stacks.css.form')
@endpush
@push('pagescript')
@include('clients::_scripts._credits')
@include('stacks.js.form')
@endpush