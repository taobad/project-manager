<?php

namespace App\Http\Livewire\Common;

use Livewire\Component;

class Activities extends Component
{
    public $activities;

    public function mount($activities)
    {
        $this->activities = $activities;
    }

    public function render()
    {
        return view(
            'livewire.common.activities',
            [
            'activities' => $this->activities,
        ]
        );
    }
}
