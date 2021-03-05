<?php

namespace Modules\Webhook\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaypalWebhookController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function ipn()
    {
        $this->request->merge(['cmd' => '_notify-validate']);
        $post = $this->request->all();
        $isValid = $this->verifyIPN($post);
        if ($isValid) {
            (new \Modules\Payments\Helpers\PaymentEngine('paypal', $post))->transact(); // $txn
            return ajaxResponse(
                [
                    'message' => 'Payment completed successfully',
                ],
                true,
                Response::HTTP_OK
            );
        }
        \Log::error('Paypal IPN was unable to process the request');
        return response()->json(
            [
                'status' => 'error',
                'message' => 'An error occurred while processing PayPal IPN!'],
            500
        );
    }

    private function verifyIPN($request)
    {
        $valid = false;
        if (settingEnabled('paypal_live')) {
            $paypal_url = "https://ipnpb.paypal.com/cgi-bin/webscr";
        } else {
            $paypal_url = "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr";
        }
        $ch = curl_init($paypal_url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-IPN-VerificationScript');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        $res = curl_exec($ch);

        if (curl_errno($ch) != 0) {
            throw new \Exception("Can't connect to PayPal to validate IPN message: " . curl_error($ch));
        } else {
            if (preg_match("/VERIFIED/", $res)) {
                $valid = true;
            }
        }
        curl_close($ch);
        return $valid;
    }
}
