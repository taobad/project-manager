<?php

namespace App\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\View\View;

class Alert extends Component
{
    /** @var string */
    public $type;
    /** @var string */
    public $icon;

    public function __construct(string $type = 'alert', $icon)
    {
        $this->type = $type;
        $this->icon = $icon;
    }

    public function render(): View
    {
        return view('components.alert');
    }

    public function message(): string
    {
        return (string) Arr::first($this->messages());
    }

    public function messages(): array
    {
        return (array) session()->get($this->type);
    }

    public function exists(): bool
    {
        return session()->has($this->type) && !empty($this->messages());
    }
}
