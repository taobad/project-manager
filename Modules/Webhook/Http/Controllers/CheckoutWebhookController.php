<?php

namespace Modules\Webhook\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Invoices\Entities\Invoice;

class CheckoutWebhookController extends Controller
{
    /**
     * Request instance
     *
     * @var Request
     */
    protected $request;
    /**
     * Invoice Model
     *
     * @var Invoice
     */
    protected $invoice;

    public $client;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->invoice = new Invoice;
        $this->client = new Client([
            'base_uri' => "https://api.2checkout.com/rest/6.0/",
        ]);
    }

    /**
     * Verify Payments via 2Checkout
     */
    public function ipn()
    {
        /* Instant Payment Notification */
        $pass = config('services.2checkout.secretKey'); /* pass to compute HASH */
        $result = ""; /* string for compute HASH for received data */
        $return = ""; /* string to compute HASH for return result */
        $signature = $this->request->HASH; /* HASH received */
        $body = "";
        /* read info received */
        ob_start();
        foreach ($this->request->all() as $key => $val) {
            $$key = $val;
            /* get values */
            if ($key != "HASH") {
                if (is_array($val)) {
                    $result .= $this->arrayExpand($val);
                } else {
                    $size = strlen(StripSlashes($val)); /*StripSlashes function to be used only for PHP versions <= PHP 5.3.0, only if the magic_quotes_gpc function is enabled */
                    $result .= $size . StripSlashes($val); /*StripSlashes function to be used only for PHP versions <= PHP 5.3.0, only if the magic_quotes_gpc function is enabled */
                }
            }
        }
        $body = ob_get_contents();
        ob_end_flush();
        $date_return = date("YmdHis");
        $return = strlen($this->request->input('IPN_PID.0')) . $this->request->input('IPN_PID.0') . strlen($this->request->input('IPN_PNAME.0')) . $this->request->input('IPN_PNAME.0');
        $return .= strlen($this->request->IPN_DATE) . $this->request->IPN_DATE . strlen($date_return) . $date_return;

        $hash = $this->hmac($pass, $result); /* HASH for data received */
        $body .= $result . "\r\n\r\nHash: " . $hash . "\r\n\r\nSignature: " . $signature . "\r\n\r\nReturnSTR: " . $return;
        if ($hash == $signature) {
            echo "Verified OK!";
            /* ePayment response */
            $result_hash = $this->hmac($pass, $return);
            echo "<EPAYMENT>" . $date_return . "|" . $result_hash . "</EPAYMENT>";
            /* Begin automated procedures (START YOUR CODE)*/
            if ($this->request->has('REFNO')) {
                $charge = $this->getRequest('orders/' . $this->request->REFNO . '/');
                if ($charge['Status'] == 'AUTHRECEIVED') {
                    (new \Modules\Payments\Helpers\PaymentEngine('checkout', $charge))->transact();
                }
            }
        } else {
            Log::error('BAD IPN Signature');
            Log::error($body);
        }

    }
    public function arrayExpand($array)
    {
        $retval = "";
        for ($i = 0; $i < sizeof($array); $i++) {
            $size = strlen(StripSlashes($array[$i])); /*StripSlashes function to be used only for PHP versions <= PHP 5.3.0, only if the magic_quotes_gpc function is enabled */
            $retval .= $size . StripSlashes($array[$i]); /*StripSlashes function to be used only for PHP versions <= PHP 5.3.0, only if the magic_quotes_gpc function is enabled */
        }
        return $retval;
    }
    public function hmac($key, $data)
    {
        $b = 64; // byte length for md5
        if (strlen($key) > $b) {
            $key = pack("H*", md5($key));
        }
        $key = str_pad($key, $b, chr(0x00));
        $ipad = str_pad('', $b, chr(0x36));
        $opad = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;
        return md5($k_opad . pack("H*", md5($k_ipad . $data)));
    }
    public function getRequest($endpoint = '')
    {
        try {
            $vendor = config('services.2checkout.merchantCode');
            $date = gmdate('Y-m-d H:i:s');
            $message = strlen($vendor) . $vendor . strlen($date) . $date;
            $hash = hash_hmac('md5', $message, config('services.2checkout.secretKey'));
            $res = $this->client->request('GET', $endpoint, [
                'headers' => [
                    'Accept' => 'application/json',
                    'X-Avangate-Authentication' => "code='{$vendor}' date='{$date}' hash='{$hash}'",
                ],
            ]);
            return json_decode($res->getBody(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            return $response->getBody()->getContents();
        }
    }
}
