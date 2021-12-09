<?php

namespace NotificationChannels\AwsPinpoint\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($exception)
    {
        $msg = sprintf(
            'AWS Pinpoint responded with an error \'%s: %s\'',
            $exception->getCode(),
            $exception->getMessage()
        );

        return new static($msg);
    }
}
