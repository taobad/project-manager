<aside class="bg-indigo-100 border-l" id="">

  <section class="scrollable">
    <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
      <section class="padder">
        @livewire('staff.stats')

        @livewire('staff.timecards')

        <header class="mt-3 text-lg text-gray-500 uppercase panel-heading">
          @langapp('pending') @langapp('tasks')
        </header>
        @livewire('staff.tasks')
        @can('menu_projects')
        <header class="text-lg text-gray-500 uppercase panel-heading">
          @langapp('pending') @langapp('projects')
        </header>
        @livewire('staff.projects')
        @endcan

        @can('menu_leads')
        <header class="text-lg text-gray-500 uppercase panel-heading">
          @langapp('pending') @langapp('leads')
        </header>
        @livewire('staff.leads')
        @endcan

        @can('menu_deals')
        <header class="text-lg text-gray-500 uppercase panel-heading">
          @langapp('pending') @langapp('deals')
        </header>
        @livewire('staff.deals')
        @endcan

      </section>





    </div>

  </section>

</aside>
<aside class="aside-lg b-l">
  <section class="vbox">

    <section class="scrollable" id="feeds">
      <div class="slim-scroll padder" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">

        @widget('Activities\Feed', ['activities' => Modules\Activity\Entities\Activity::where('user_id', Auth::id())->take(50)->orderByDesc('id')->get(), 'view' => 'dashboard'])

      </div>
    </section>

  </section>
</aside>