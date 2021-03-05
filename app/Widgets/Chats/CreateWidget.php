<?php

namespace App\Widgets\Chats;

use Arrilot\Widgets\AbstractWidget;

class CreateWidget extends AbstractWidget
{

     /**
      * The configuration array.
      *
      * @var array
      */
    protected $config = [
        'chatable_type' => '',
        'chatable_id' => '',
        'hasFiles' => false,
        'cannedResponse' => false
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data['chatable_type'] = $this->config['chatable_type'];
        $data['chatable_id'] = $this->config['chatable_id'];
        $data['hasFiles'] = $this->config['hasFiles'];
        $data['cannedResponse'] = $this->config['cannedResponse'];
        return view(
            'widgets.chats.create_widget',
            [
            'config' => $this->config,
            ]
        )->with($data);
    }
}
