<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Form extends Component
{
    /** @var string */
    public $action;

    /** @var string */
    public $method;

    /** @var bool */
    public $hasFiles;

    public function __construct(string $action, string $method = 'POST', bool $hasFiles = false)
    {
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->hasFiles = $hasFiles;
    }

    public function render(): View
    {
        return view('components.form');
    }
}
