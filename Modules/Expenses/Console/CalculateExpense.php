<?php

namespace Modules\Expenses\Console;

use Illuminate\Console\Command;
use Modules\Expenses\Entities\Expense;

class CalculateExpense extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'expenses:balance {expense?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate expenses tax';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('expense');

        if ($id > 0) {
            $expense = Expense::findOrFail($id);
            $expense->afterModelSaved();
        } else {
            Expense::chunk(
                200,
                function ($expenses) {
                    foreach ($expenses as $expense) {
                        $expense->afterModelSaved();
                    }
                }
            );
        }
        $this->info('Expenses calculated successfully');
    }
}
