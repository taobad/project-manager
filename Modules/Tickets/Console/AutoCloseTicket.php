<?php

namespace Modules\Tickets\Console;

use Illuminate\Console\Command;
use Modules\Tickets\Entities\Ticket;

class AutoCloseTicket extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tickets:autoclose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto close pending tickets.';

    protected $ticket;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->ticket = new Ticket;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->ticket->pending()->get() as $tkt) {
            $lastActivityDays = $tkt->comments->count() > 0 ? now()->diffInDays($tkt->comments()->latest()->first()->created_at) : now()->diffInDays($tkt->created_at);
            if ($lastActivityDays >= get_option('auto_close_ticket')) {
                $tkt->closeTicket();
            }
        }
        $this->info('Autoclosed tickets successfully');
    }
}
