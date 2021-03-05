<?php

namespace Modules\Deals\Console;

use App\Entities\Computed;
use Illuminate\Console\Command;
use Modules\Deals\Entities\Deal;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ComputeForecast extends Command
{
    protected $deal;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'deals:forecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate deal forecasts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->deal = new Deal;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = new \DateTime(date('Y-m'));
        $period = new \DatePeriod($now, new \DateInterval('P1M'), 3);

        foreach ($period as $cdate) {
            $this->computeOpenDeals($cdate);
            $this->computeWonDeals($cdate);
        }
        $this->info('✔︎ Deal forecast calculated successfully');
    }

    public function computeOpenDeals($cdate)
    {
        $total = 0;
        foreach ($this->deal->open()->whereYear('due_date', $cdate->format('Y'))->whereMonth('due_date', $cdate->format('m'))->get() as $deal) {
            if ($deal->currency != get_option('default_currency')) {
                $total += convertCurrency($deal->currency, $deal->deal_value);
            } else {
                $total += $deal->deal_value;
            }
            Computed::updateOrCreate(
                ['key' => 'deals_open_'.$cdate->format('m').'_'.$cdate->format('Y').'_'.$deal->pipeline],
                ['value' => formatDecimal($total)]
            );
        }
    }

    public function computeWonDeals($cdate)
    {
        $total = 0;
        foreach ($this->deal->won()->whereYear('due_date', $cdate->format('Y'))->whereMonth('due_date', $cdate->format('m'))->get() as $deal) {
            if ($deal->currency != get_option('default_currency')) {
                $total += convertCurrency($deal->currency, $deal->deal_value);
            } else {
                $total += $deal->deal_value;
            }
            Computed::updateOrCreate(
                ['key' => 'deals_won_'.$cdate->format('m').'_'.$cdate->format('Y').'_'.$deal->pipeline],
                ['value' => formatDecimal($total)]
            );
        }
    }
}
