@extends('layouts.app')
@section('content')
<section id="content" class="bg-indigo-100">
  <section class="vbox">
    <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
      <div class="flex justify-between text-gray-500">
        <div>
          <span class="text-xl font-semibold text-gray-600">@langapp('contacts')</span>
        </div>
        <div>
          @can('users_create')
          <a href="{{  route('contacts.create')  }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
            @icon('solid/plus') @langapp('create')
          </a>
          @endcan
          @can('contacts_create')
          <div class="btn-group">
            <button class="btn {{themeButton()}} dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              @langapp('import') <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="{{ route('contacts.import', ['type' => 'contacts']) }}" data-toggle="ajaxModal">@langapp('csv_file')</a></li>
              <li><a href="{{ route('contacts.import', ['type' => 'google']) }}">Google @langapp('contacts')</a></li>
            </ul>
          </div>
          @endcan
          @can('contacts_view')
          <a href="{{ route('contacts.export') }}" class="btn {{themeButton()}}">
            @icon('solid/download') CSV
          </a>
          @endcan

          <div class="btn-group">
            <a href="{{ route('contacts.index', ['view' => 'table']) }}" data-toggle="tooltip" title="Table View" data-placement="bottom" class="btn {{themeButton()}}">
              @icon('solid/bars')
            </a>
            <a href="{{ route('contacts.index', ['view' => 'grid']) }}" data-toggle="tooltip" title="Grid View" data-placement="bottom" class="btn {{themeButton()}}">
              @icon('solid/columns')
            </a>
          </div>
        </div>
      </div>
    </header>
    <section class="scrollable wrapper scrollpane">

      @if ($displayType == 'table')
      @include('contacts::table_view')
      @endif
      @if ($displayType == 'grid')
      {!! Form::open(['route' => 'contacts.search', 'class' => '']) !!}
      <div class="input-group m-xs">

        <input type="text" class="input-sm form-control contact-search search" name="keyword" placeholder="Enter contact name">
        <span class="input-group-btn">
          <button class="btn {{themeButton()}}" type="submit">@icon('solid/search') @langapp('search')</button>
        </span>
      </div>
      {!! Form::close() !!}
      <div id="ajaxData"></div>
      @endif


    </section>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@push('pagestyle')
@include('stacks.css.form')
@endpush
@push('pagescript')
@if ($displayType == 'grid')
@include('contacts::_scripts._ajax')
@endif
@include('stacks.js.form')
@endpush
@endsection