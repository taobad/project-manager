<section class="panel panel-default">
  <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
    <div class="flex justify-between text-gray-500">

      <div>
        @if (session('taskview') == 'table')

        <div class="btn-group">
          <button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown">
            @langapp('filter')
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li>
              <a href="{{ route('projects.view', ['project' => $project->id, 'tab' => 'tasks', 'item' => null, 'filter' => 'backlog']) }}">
                @langapp('backlog')
              </a>
            </li>
            <li>
              <a href="{{ route('projects.view', ['project' => $project->id, 'tab' => 'tasks', 'item' => null, 'filter' => 'ongoing']) }}">
                @langapp('ongoing')
              </a>
            </li>
            <li>
              <a href="{{ route('projects.view', ['project' => $project->id, 'tab' => 'tasks', 'item' => null, 'filter' => 'done']) }}">
                @langapp('done')
              </a>
            </li>
            <li>
              <a href="{{ route('projects.view', ['project' => $project->id, 'tab' => 'tasks', 'item' => null, 'filter' => 'overdue']) }}">
                @langapp('overdue')
              </a>
            </li>
            <li>
              <a href="{{ route('projects.view', ['project' => $project->id, 'tab' => 'tasks', 'item' => null, 'filter' => 'mine']) }}">
                @langapp('mine')
              </a>
            </li>
            <li>
              <a href="{{ route('projects.view', ['project' => $project->id, 'tab' => 'tasks', 'item' => null, 'filter' => 'all']) }}">
                @langapp('all')
              </a>
            </li>
          </ul>
        </div>
        @endif

        @if (can('tasks_create') || $project->isTeam() || $project->setting('client_add_tasks'))
        <a href="{{  route('tasks.create', ['project' => $project->id])  }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
          @icon('solid/plus') @langapp('create')
        </a>
        @endif

      </div>

      <div>
        <div class="btn-group">
          <a href="{{ route('set.view.type', ['type' => 'tasks', 'view' => 'table']) }}" data-toggle="tooltip" title="Table" data-placement="bottom" class="btn {{themeButton()}}">
            @icon('solid/bars')
          </a>
          <a href="{{ route('set.view.type', ['type' => 'tasks', 'view' => 'kanban']) }}" data-toggle="tooltip" title="Kanban" data-placement="bottom"
            class="btn {{themeButton()}}">
            @icon('solid/columns')
          </a>
        </div>
        @admin
        <a href="{{ route('settings.stages.show', 'tasks') }}" data-toggle="ajaxModal" class="btn {{themeButton()}}" data-rel="tooltip" title="@langapp('stages')"
          data-placement="bottom">
          @icon('solid/cogs')
        </a>
        @endadmin
      </div>
    </div>
  </header>

  @include('tasks::partial._'.session('taskview', 'table').'_view')

</section>