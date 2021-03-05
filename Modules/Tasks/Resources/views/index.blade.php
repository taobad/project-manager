@extends('layouts.app')
@section('content')
<section id="content" class="bg-indigo-100">
  <section class="vbox">
    <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
      <div class="flex justify-between text-gray-500">
        <div>
          <div class="btn-group">
            <button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown">
              @langapp('filter')
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li>
                <a href="{{ route('tasks.index', ['filter' => 'backlog']) }}">
                  @langapp('backlog')
                </a>
              </li>
              <li>
                <a href="{{ route('tasks.index', ['filter' => 'ongoing']) }}">@langapp('ongoing')</a>
              </li>
              <li><a href="{{ route('tasks.index', ['filter' => 'done']) }}">@langapp('done')</a></li>
              <li>
                <a href="{{ route('tasks.index', ['filter' => 'overdue']) }}">@langapp('overdue')</a>
              </li>
              <li>
                <a href="{{ route('tasks.index', ['filter' => 'mine']) }}">@langapp('mine')</a>
              </li>
              <li><a href="{{ route('tasks.index') }}">@langapp('all') </a></li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <section class="scrollable wrapper" id="task-list">

      @livewire('task.index-table')

    </section>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@endsection