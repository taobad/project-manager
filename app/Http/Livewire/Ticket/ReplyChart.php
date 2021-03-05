<?php

namespace App\Http\Livewire\Ticket;

use Livewire\Component;

class ReplyChart extends Component
{
    public function render()
    {
        $year = chartYear();
        $metrics = new \App\Helpers\Report;

        $tickets = [
            'jan' => $metrics->ticketsByMonth(1, $year),
            'feb' => $metrics->ticketsByMonth(2, $year),
            'mar' => $metrics->ticketsByMonth(3, $year),
            'apr' => $metrics->ticketsByMonth(4, $year),
            'may' => $metrics->ticketsByMonth(5, $year),
            'jun' => $metrics->ticketsByMonth(6, $year),
            'jul' => $metrics->ticketsByMonth(7, $year),
            'aug' => $metrics->ticketsByMonth(8, $year),
            'sep' => $metrics->ticketsByMonth(9, $year),
            'oct' => $metrics->ticketsByMonth(10, $year),
            'nov' => $metrics->ticketsByMonth(11, $year),
            'dec' => $metrics->ticketsByMonth(12, $year),
        ];
        $replies = [
            'jan' => $metrics->repliesByMonth(1, $year),
            'feb' => $metrics->repliesByMonth(2, $year),
            'mar' => $metrics->repliesByMonth(3, $year),
            'apr' => $metrics->repliesByMonth(4, $year),
            'may' => $metrics->repliesByMonth(5, $year),
            'jun' => $metrics->repliesByMonth(6, $year),
            'jul' => $metrics->repliesByMonth(7, $year),
            'aug' => $metrics->repliesByMonth(8, $year),
            'sep' => $metrics->repliesByMonth(9, $year),
            'oct' => $metrics->repliesByMonth(10, $year),
            'nov' => $metrics->repliesByMonth(11, $year),
            'dec' => $metrics->repliesByMonth(12, $year),
        ];

        return view('livewire.ticket.reply-chart', [
            'year' => $year,
            'tickets' => $tickets,
            'replies' => $replies,
        ]);
    }
}
