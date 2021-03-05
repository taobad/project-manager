<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Text extends Component
{
    /** @var string */
    public $name;

    /** @var string */
    public $id;

    /** @var string */
    public $type;

    /** @var string */
    public $value;

    public function __construct(string $name, string $id = null, string $type = 'text', string $value = '')
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->type = $type;
        $this->value = old($name, $value);
    }

    public function render()
    {
        return view('components.inputs.text');
    }
}
