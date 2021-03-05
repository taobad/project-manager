<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;
use Illuminate\View\View;

class Pikaday extends Component
{
    /** @var string */
    public $name;

    /** @var string */
    public $id;

    /** @var string */
    public $type;

    /** @var string */
    public $value;

    /** @var string */
    public $format;

    /** @var string */
    public $placeholder;

    /** @var array */
    public $options;

    protected static $assets = ['moment', 'pikaday'];

    public function __construct(
        string $name,
        string $id = null,
        string $value = '',
        string $type = 'text',
        string $format = 'DD/MM/YYYY',
        string $placeholder = null,
        array $options = []
    ) {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->type = $type;
        $this->value = old($name, $value ?? '');

        $this->format = $format;
        $this->placeholder = $placeholder ?? $format;
        $this->options = $options;
    }

    public function options(): array
    {
        return array_merge([
            'format' => $this->format,
        ], $this->options);
    }

    public function jsonOptions(): string
    {
        if (empty($this->options())) {
            return '';
        }

        return ', ...' . json_encode((object) $this->options());
    }

    public function render(): View
    {
        return view('components.inputs.pikaday');
    }
}
