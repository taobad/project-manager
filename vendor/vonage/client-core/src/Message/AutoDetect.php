<?php

/**
 * Vonage Client Library for PHP
 *
 * @copyright Copyright (c) 2016-2020 Vonage, Inc. (http://vonage.com)
 * @license https://github.com/Vonage/vonage-php-sdk-core/blob/master/LICENSE.txt Apache License 2.0
 */

declare(strict_types=1);

namespace Vonage\Message;

/**
 * SMS Text Message
 */
class AutoDetect extends Message
{
    public const TYPE = 'text';

    /**
     * Message Body
     *
     * @var string
     */
    protected $text;

    public function __construct(string $to, string $from, string $text, array $additional = [])
    {
        parent::__construct($to, $from, $additional);

        $this->enableEncodingDetection();
        $this->requestData['text'] = $text;
    }
}
