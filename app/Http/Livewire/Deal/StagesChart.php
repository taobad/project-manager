<?php

namespace App\Http\Livewire\Deal;

use App\Entities\Category;
use Livewire\Component;

class StagesChart extends Component
{
    public function render()
    {
        $pipeline = $this->getPipeline(request('pipeline'));
        $stages = Category::wherePipeline($pipeline)->get();

        return view('livewire.deal.stages-chart', [
            'stages' => $stages,
        ]);
    }

    private function getPipeline($req)
    {
        if (is_null($req)) {
            return Category::where('module', 'pipeline')->first()->id;
        }
        return $req;
    }
}
