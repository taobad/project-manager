<aside class="b-l bg" id="">
    <ul class="text-xs text-gray-600 uppercase dashmenu no-border no-radius">
        @modactive('invoices')
        <li class="{{ $dashboard == 'invoices' ? themeText('font-semibold') : '' }}">
            <a href="{{ route('dashboard.index', ['dashboard' => 'invoices']) }}">
                @icon('solid/file-invoice-dollar') @langapp('invoicing')
            </a>
        </li>
        @endmod
        @modactive('deals')
        <li class="{{ $dashboard == 'deals' ? themeText('font-semibold') : '' }}">
            <a href="{{ route('dashboard.index', ['dashboard' => 'deals']) }}">
                @icon('solid/chart-line') @langapp('sales')
            </a>
        </li>
        @endmod
        @modactive('expenses')
        <li class="{{ $dashboard == 'expenses' ? themeText('font-semibold') : '' }}">
            <a href="{{ route('dashboard.index', ['dashboard' => 'expenses']) }}">
                @icon('solid/dollar-sign') @langapp('expenses')
            </a>
        </li>
        @endmod
        @modactive('payments')
        <li class="{{ $dashboard == 'payments' ? themeText('font-semibold') : '' }}">
            <a href="{{ route('dashboard.index', ['dashboard' => 'payments']) }}">
                @icon('solid/credit-card') @langapp('payments')
            </a>
        </li>
        @endmod
        @modactive('projects')
        <li class="{{ $dashboard == 'projects' ? themeText('font-semibold') : '' }}">
            <a href="{{ route('dashboard.index', ['dashboard' => 'projects']) }}">
                @icon('solid/project-diagram') @langapp('projects')
            </a>
        </li>
        @endmod
        @modactive('tickets')
        <li class="{{ $dashboard == 'tickets' ? themeText('font-semibold') : '' }}">
            <a href="{{ route('dashboard.index', ['dashboard' => 'tickets']) }}">
                @icon('solid/life-ring') @langapp('ticketing')
            </a>
        </li>
        @endmod
    </ul>
    <section class="scrollable">
        <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
            <section class="padder">
                @include('dashboard::_includes.'.$dashboard)
            </section>
        </div>
    </section>
</aside>
<aside class="bg-white border aside-lg">
    <section class="vbox">
        <section class="scrollable" id="feeds">
            <div class="p-2 slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
                @include('dashboard::_sidebar.'.$dashboard)
            </div>
        </section>
    </section>
</aside>