<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;
use Illuminate\View\View;

class Checkbox extends Component
{
    /** @var bool */
    public $checked;

    public function __construct(string $name, string $id = null, bool $checked = false)
    {
        parent::__construct($name, $id, 'checkbox');

        $this->checked = (bool) old($name, $checked);
    }

    public function render(): View
    {
        return view('components.inputs.checkbox');
    }
}
