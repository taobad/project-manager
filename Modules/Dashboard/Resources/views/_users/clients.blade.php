<aside class="bg-indigo-100 border-l" id="">


  <section class="scrollable">
    <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
      <section class="padder">
        @livewire('clients.stats')

        @if (Auth::user()->profile->company)
        <div class="py-3 m-1">
          <header class="text-lg text-gray-500 uppercase panel-heading">@langapp('outstanding') @langapp('invoices')</header>
          @livewire('clients.outstanding')
        </div>

        <div class="py-3 m-1">
          <header class="text-lg text-gray-500 uppercase panel-heading">@langapp('pending') @langapp('estimates')</header>
          @livewire('clients.estimates')
        </div>

        <div class="py-3 m-1">
          <header class="text-lg text-gray-500 uppercase panel-heading">@langapp('pending') @langapp('projects')</header>
          @livewire('clients.projects')
        </div>

        <div class="py-3 m-1">
          <header class="text-lg text-gray-500 uppercase panel-heading">@langapp('pending') @langapp('tickets')</header>
          @livewire('clients.tickets')
        </div>

        @endif

      </section>
    </div>

  </section>

</aside>
<aside class="aside-lg b-l">
  <section class="vbox">

    <section class="scrollable" id="feeds">
      <div class="slim-scroll padder" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">

        @widget('Activities\Feed', ['activities' => Auth()->user()->feeds()->with(['user'])->orderByDesc('id')->take(50)->get(), 'view' => 'dashboard'])

      </div>
    </section>

  </section>
</aside>