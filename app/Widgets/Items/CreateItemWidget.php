<?php

namespace App\Widgets\Items;

use Arrilot\Widgets\AbstractWidget;

class CreateItemWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'module_id' => '',
        'module' => '',
        'order' => '',
        'taxes' => false,
        'discount' => false,
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data['module_id'] = $this->config['module_id'];
        $data['module'] = $this->config['module'];
        $data['order'] = $this->config['order'];
        $data['scope'] = $this->config['module'];
        $data['withTaxes'] = $this->config['taxes'];
        $data['withDiscount'] = $this->config['discount'];

        return view(
            'widgets.items.create_item_widget',
            [
                'config' => $this->config,
            ]
        )->with($data);
    }
}
