<?php

namespace App\Widgets\Tasks;

use Arrilot\Widgets\AbstractWidget;

class Today extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        return view('widgets.tasks.today', [
            'config' => $this->config,
        ]);
    }
}
