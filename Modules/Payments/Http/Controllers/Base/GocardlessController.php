<?php
namespace Modules\Payments\Http\Controllers\Base;

use App\Entities\Country;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Clients\Entities\Client;
use Modules\Invoices\Entities\Invoice;
use Modules\Payments\Entities\GocardlessMandate;
use Modules\Payments\Jobs\GocardlessPayJob;

abstract class GocardlessController extends Controller
{
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Invoice model
     *
     * @var \Modules\Invoices\Entities\Invoice
     */
    protected $invoice;
    protected $client;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->invoice = new Invoice;

        $this->client = new \GoCardlessPro\Client([
            'access_token' => config('gocardless.token'),
            'environment' => config('gocardless.environment') == 'SANDBOX' ? \GoCardlessPro\Environment::SANDBOX : \GoCardlessPro\Environment::LIVE,
        ]);
    }

    public function redirect()
    {
        $invoice = $this->invoice->find($this->request->id);
        try {
            $authUserName = Auth::check() ? Auth::user()->name : optional($invoice->company->contact)->name;
            $redirectFlow = $this->client->redirectFlows()->create([
                "params" => [
                    "description" => 'Payment for invoice ' . $invoice->reference_no,
                    "session_token" => session()->getId(),
                    "success_redirect_url" => route('gocardless.confirm'),
                    "prefilled_customer" => [
                        "given_name" => splitNames($authUserName)['firstName'],
                        "family_name" => splitNames($authUserName)['lastName'],
                        "email" => $invoice->company->email,
                        "address_line1" => !is_null($invoice->company->billing_street) ? $invoice->company->billing_street : '',
                        "company_name" => $invoice->company->name,
                        "language" => $invoice->company->locale,
                        'postal_code' => !is_null($invoice->company->billing_zip) ? $invoice->company->billing_zip : '',
                        "city" => !is_null($invoice->company->billing_city) ? $invoice->company->billing_city : '',
                        "country_code" => Country::where('name', $invoice->company->billing_country)->first()->code,
                    ],
                ],
            ]);
            GocardlessMandate::create([
                'invoice_id' => $invoice->id,
                'client_id' => $invoice->company->id,
                'gocardless_flow_id' => $redirectFlow->id,
                'amount' => $this->request->amount * 100,
                'idempotency_key' => genUnique(),
            ]);
            $response = [
                'redirect_id' => $redirectFlow->id,
                'url' => $redirectFlow->redirect_url,
            ];
            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function confirm()
    {
        try {
            $mandate = GocardlessMandate::where('gocardless_flow_id', $this->request->redirect_flow_id)->first();
            $redirectFlow = $this->client->redirectFlows()->complete($this->request->redirect_flow_id, [
                "params" => [
                    "session_token" => session()->getId(),
                ],
            ]);
            // Save to client database
            $mandate->update([
                'gocardless_mandate' => $redirectFlow->links->mandate,
                'gocardless_customer' => $redirectFlow->links->customer,
            ]);
            // Initialize payment request Job
            GocardlessPayJob::dispatch($mandate);
            $data = ['invoice_id' => $mandate->invoice->id];
            return view('payments::gocardless_payment')->with($data);
            // return \Redirect::to($redirectFlow->confirmation_url);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
