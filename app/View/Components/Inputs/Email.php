<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;
use Illuminate\View\View;

class Email extends Component
{
    public function __construct(string $name = 'email', string $id = null, string $value = '')
    {
        parent::__construct($name, $id, 'email', $value);
    }

    public function render(): View
    {
        return view('components.inputs.email');
    }
}
