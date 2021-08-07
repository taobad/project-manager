<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'notes/*',
        'stripe/*',
        'webhook/telegram/*',
        'telescope/*',
        'payments/paypal/success',
        'webhook/paypal/*',
        'webhook/mollie/*',
        'webhook/razorpay/*',
        'webhook/wepay/*',
        'webhook/2checkout/*',
        'webhook/sentry/*',
        'webhook/github-issues/*',
        'payments/paytm/status',
        'payments/pagseguro/callback',
        'webhook/pagseguro/ipn',
        'webhook/whatsapp/incoming/*',
        'webhook/sms/inbound/*',
        'webhook/aircall/inbound/*',
        'webhook/ivr/*',
        'webhook/gocardless/*',
    ];
}
