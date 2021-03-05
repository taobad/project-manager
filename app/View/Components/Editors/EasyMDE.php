<?php

namespace App\View\Components\Editors;

use Illuminate\View\Component;
use Illuminate\View\View;

class EasyMDE extends Component
{
    /** @var string */
    public $name;

    /** @var string */
    public $id;

    /** @var array */
    public $options;

    protected static $assets = ['easy-mde'];

    public function __construct(string $name, string $id = null, array $options = [])
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->options = $options;
    }

    public function options(): array
    {
        return array_merge([
            'forceSync' => true,
            'autoDownloadFontAwesome' => false,
            'placeholder' => 'Type something..',
            'promptURLs' => true,
            'minHeight' => '200px',
            'autosave' => [
                'enabled' => config('system.editor.autosave'),
                'uniqueId' => auth()->id() . '_' . strtolower($this->id),
            ],
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
        return view('components.editors.easy-mde');
    }
}
