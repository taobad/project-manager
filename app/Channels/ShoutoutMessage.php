<?php

namespace App\Channels;

class ShoutoutMessage
{
    public $body;
    public $recipients;

    public function __construct($body = '')
    {
        if (!empty($body)) {
            $this->body = trim($body);
        }
    }

    public static function create($body = '')
    {
        return new static($body);
    }

    public function setBody($body)
    {
        $this->body = trim($body);

        return $this;
    }

    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;

        return $this;
    }
}
