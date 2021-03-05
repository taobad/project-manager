<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Error extends Component
{
    /** @var string */
    public $field;

    /** @var string */
    public $bag;

    public function __construct(string $field, string $bag = 'default')
    {
        $this->field = $field;
        $this->bag = $bag;
    }

    public function render()
    {
        return view('components.error');
    }

    public function messages(ViewErrorBag $errors): array
    {
        $bag = $errors->getBag($this->bag);

        return $bag->has($this->field) ? $bag->get($this->field) : [];
    }
}
