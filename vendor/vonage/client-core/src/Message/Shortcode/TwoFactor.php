<?php

/**
 * Vonage Client Library for PHP
 *
 * @copyright Copyright (c) 2016-2020 Vonage, Inc. (http://vonage.com)
 * @license https://github.com/Vonage/vonage-php-sdk-core/blob/master/LICENSE.txt Apache License 2.0
 */

declare(strict_types=1);

namespace Vonage\Message\Shortcode;

use Vonage\Message\Shortcode;

class TwoFactor extends Shortcode
{
    /**
     * @var string
     */
    protected $type = '2fa';
}
