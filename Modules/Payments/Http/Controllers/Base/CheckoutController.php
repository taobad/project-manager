<?php

namespace Modules\Payments\Http\Controllers\Base;

use App\Entities\Country;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Invoices\Entities\Invoice;

abstract class CheckoutController extends Controller
{
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Invoice Model
     *
     * @var \Modules\Invoices\Entities\Invoice
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
    public function post($endpoint = '', $data)
    {
        try {
            $vendor = config('services.2checkout.merchantCode');
            $date = gmdate('Y-m-d H:i:s');
            $message = strlen($vendor) . $vendor . strlen($date) . $date;
            $hash = hash_hmac('md5', $message, config('services.2checkout.secretKey'));
            $res = $this->client->request('POST', $endpoint, [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json',
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

    public function renderResponse($res, $return_fn)
    {
        return $return_fn($res);
    }

    public function checkout()
    {
        $invoice = $this->invoice->find($this->request->id);
        $countryCode = Country::where('name', $invoice->company->billing_country)->first()->code;
        $authUserName = Auth::check() ? Auth::user()->name : optional($invoice->company->contact)->name;
        $data = [
            'Country' => strtolower($countryCode),
            'Currency' => strtolower($invoice->currency),
            'CustomerIP' => $this->request->ip(),
            'CustomerReference' => $invoice->company->id,
            'ExternalCustomerReference' => $invoice->company->code,
            'ExternalReference' => $invoice->id,
            'Language' => $invoice->company->locale,
            'Source' => url('/'),
            'Affiliate' => [],
            'BillingDetails' => (object) [
                'FirstName' => splitNames($authUserName)['firstName'],
                'LastName' => splitNames($authUserName)['lastName'],
                'Address1' => $invoice->company->billing_street,
                'City' => $invoice->company->billing_city,
                'State' => $invoice->company->billing_state,
                'Zip' => $invoice->company->billing_zip,
                'CountryCode' => $countryCode,
                'Email' => $invoice->company->email,
                'Phone' => $invoice->company->phone,
            ],
            'Items' => array(
                (object) [
                    'Name' => 'Dynamic product',
                    'Description' => 'Payment for invoice ' . $invoice->reference_no,
                    'Quantity' => 1,
                    'IsDynamic' => true,
                    'Tangible' => false,
                    'PurchaseType' => "PRODUCT",
                    'Price' => (object) [
                        'Amount' => $this->request->amount,
                        'Type' => 'CUSTOM',
                    ],
                ],
            ),
            'PaymentDetails' => (object) [
                'Currency' => $invoice->currency,
                'CustomerIP' => $this->request->ip(),
                'PaymentMethod' => (object) [
                    'EesToken' => $this->request->token,
                    'Vendor3DSReturnURL' => route('payments.twocheckout.secure.success'),
                    'Vendor3DSCancelURL' => route('payments.twocheckout.secure.cancel'),
                ],
                'Type' => 'EES_TOKEN_PAYMENT',
            ],
        ];

        $charge = $this->post('orders/', (object) $data);

        toastr()->success('Thank you for your payment. Transaction in progress. Status: ' . $charge['Status'], langapp('response_status'));
        return redirect()->route('invoices.view', $invoice->id);
    }
    public function checkoutSecureSuccess()
    {
        toastr()->success('3D Secure successful', langapp('response_status'));
        return redirect()->route('invoices.index');
    }
    public function checkoutSecureCancel()
    {
        toastr()->error('3D Secure failed', langapp('response_status'));
        return redirect()->route('invoices.index');
    }
}
