<?php

namespace Modules\Clients\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Clients\Entities\Client;
use Modules\Clients\Http\Requests\ClientRequest;
use Modules\Clients\Transformers\ClientResource;
use Modules\Clients\Transformers\ClientsResource;
use Modules\Contacts\Transformers\ContactsResource;
use Modules\Creditnotes\Transformers\CreditsResource;
use Modules\Deals\Transformers\DealsResource;
use Modules\Estimates\Transformers\EstimatesResource;
use Modules\Expenses\Transformers\ExpensesResource;
use Modules\Invoices\Transformers\InvoicesResource;
use Modules\Payments\Transformers\PaymentsResource;
use Modules\Projects\Transformers\ProjectsResource;
use Modules\Subscriptions\Transformers\SubscriptionsResource;
use Modules\Users\Entities\User;

class ClientsApiController extends Controller
{
    /**
     * Client model
     *
     * @var \Modules\Clients\Entities\Client
     */
    protected $client;
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Client logo directory path
     *
     * @var string
     */
    protected $logos_dir;

    /**
     * Create a new controller instance.
     */
    public function __construct(Request $request)
    {
        $this->middleware('localize');
        $this->request = $request;
        $this->client = new Client;
        $this->logos_dir = config('system.logos_dir') . '/';
    }

    public function index()
    {
        $clients = new ClientsResource(
            $this->client->with(['contact:id,username,email,name'])
                ->orderByDesc('id')
                ->paginate(40)
        );
        return response($clients, Response::HTTP_OK);
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show($id = null)
    {
        $client = $this->client->findOrFail($id);
        return response(new ClientResource($client), Response::HTTP_OK);
    }

    public function save(ClientRequest $request)
    {
        $client = $this->client->create($request->all());

        if (strlen($request->contact_email)) {
            $user = User::create(
                [
                    'username' => $request->contact_email,
                    'email' => $request->contact_email,
                    'name' => $request->contact_name,
                    'password' => 'secret',
                ]
            );
            $user->profile->update(
                [
                    'company' => $client->id,
                    'country' => $client->country,
                ]
            );
            $user->update(['email_verified_at' => config('system.verification') ? null : now()]);
            $client->update(['primary_contact' => $user->id]);
        }
        if ($request->hasFile('logo')) {
            $this->uploadLogo($request, $client);
        }
        return ajaxResponse(
            [
                'id' => $client->id,
                'message' => langapp('saved_successfully'),
                'redirect' => route('clients.view', $client->id),
            ],
            true,
            Response::HTTP_CREATED
        );
    }

    public function update(ClientRequest $request, $id = null)
    {
        $client = $this->client->findOrFail($id);
        $client->update($request->all());

        if ($request->hasFile('logo')) {
            $this->uploadLogo($request, $client);
        }
        $data = [
            'billing_street' => $request->billing_street,
            'billing_city' => $request->billing_city,
            'billing_state' => $request->billing_state,
            'billing_zip' => $request->billing_zip,
            'billing_country' => $request->billing_country,
            'shipping_street' => $request->shipping_street,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_zip' => $request->shipping_zip,
            'shipping_country' => $request->shipping_country,
        ];
        if ($request->has('update_invoices_addresses')) {
            // Update addresses for customer invoices except paid invoices and accepted estimates
            $client->invoices()->where('status', '!=', 'fully_paid')->update($data);
            $client->estimates()->where('status', '!=', 'Accepted')->update($data);
        }
        if ($request->has('update_credits_addresses')) {
            // Update addresses for customer credits except closed
            $client->credits()->where('status', '!=', 'closed')->update($data);
        }
        return ajaxResponse(
            [
                'id' => $client->id,
                'message' => langapp('changes_saved_successful'),
                'redirect' => route('clients.view', $client->id),
            ],
            true,
            Response::HTTP_OK
        );
    }

    private function uploadLogo($request, $client)
    {
        $currentLogo = $client->getRawOriginal('logo');
        if (Storage::exists($this->logos_dir . $currentLogo)) {
            Storage::delete($this->logos_dir . $currentLogo);
        }
        Storage::putFile($this->logos_dir, $request->file('logo'), 'public');
        $client->update(['logo' => $request->logo->hashName()]);
    }
    /**
     * Show the specified client contacts.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function contacts($id = null)
    {
        $client = $this->client->findOrFail($id);
        $contacts = new ContactsResource($client->contacts()->paginate(16));
        if ($this->request->has('json')) {
            $data['contacts'] = $contacts;
            return view('clients::_ajax._contacts')->with($data);
        }
        return response($contacts, Response::HTTP_OK);
    }
    /**
     * Show the specified client contacts.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function projects($id = null)
    {
        $client = $this->client->findOrFail($id);
        $projects = new ProjectsResource($client->projects()->orderBy('id', 'desc')->paginate(16));
        if ($this->request->has('json')) {
            $data['projects'] = $projects;
            return view('clients::_ajax._projects')->with($data);
        }
        return response($projects, Response::HTTP_OK);
    }

    /**
     * Show the specified client contacts.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function invoices($id = null)
    {
        $client = $this->client->findOrFail($id);
        $invoices = new InvoicesResource($client->invoices()->orderBy('id', 'desc')->paginate(16));
        if ($this->request->has('json')) {
            $data['invoices'] = $invoices;
            return view('clients::_ajax._invoices')->with($data);
        }
        return response($invoices, Response::HTTP_OK);
    }

    /**
     * Show the specified client creditnotes.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function credits($id = null)
    {
        $client = $this->client->findOrFail($id);
        $credits = new CreditsResource($client->credits()->orderBy('id', 'desc')->paginate(16));
        if ($this->request->has('json')) {
            $data['credits'] = $credits;
            return view('clients::_ajax._credits')->with($data);
        }
        return response($credits, Response::HTTP_OK);
    }

    /**
     * Show the specified client contacts.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function estimates($id = null)
    {
        $client = $this->client->findOrFail($id);
        $estimates = new EstimatesResource($client->estimates()->orderBy('id', 'desc')->paginate(16));
        if ($this->request->has('json')) {
            $data['estimates'] = $estimates;
            return view('clients::_ajax._estimates')->with($data);
        }
        return response($estimates, Response::HTTP_OK);
    }
    /**
     * Show the specified client contacts.
     *
     * @param  string $id
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function payments($id = null)
    {
        $client = $this->client->findOrFail($id);
        $payments = new PaymentsResource($client->payments()->orderBy('id', 'desc')->paginate(20));
        if ($this->request->has('json')) {
            $data['payments'] = $payments;
            return view('clients::_ajax._payments')->with($data);
        }
        return response($payments, Response::HTTP_OK);
    }
    /**
     * Show client subscriptions
     *
     * @param  string $id
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function subscriptions($id = null)
    {
        $client = $this->client->findOrFail($id);
        $subscriptions = new SubscriptionsResource($client->subscriptions()->orderBy('id', 'desc')->paginate(20));
        if ($this->request->has('json')) {
            $data['subscriptions'] = $subscriptions;
            return view('clients::_ajax._subscriptions')->with($data);
        }
        return response($subscriptions, Response::HTTP_OK);
    }

    /**
     * Show the specified client contacts.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function expenses($id = null)
    {
        $client = $this->client->findOrFail($id);
        $expenses = new ExpensesResource($client->expenses()->orderBy('id', 'desc')->paginate(16));
        if ($this->request->has('json')) {
            $data['expenses'] = $expenses;
            return view('clients::_ajax._expenses')->with($data);
        }
        return response($expenses, Response::HTTP_OK);
    }

    /**
     * Show the specified client contacts.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function deals($id = null)
    {
        $client = $this->client->findOrFail($id);
        $deals = new DealsResource($client->deals()->orderBy('id', 'desc')->paginate(16));
        if ($this->request->has('json')) {
            $data['deals'] = $deals;
            return view('clients::_ajax._deals')->with($data);
        }
        return response($deals, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id = null)
    {
        DB::beginTransaction();
        try {
            $client = $this->client->findOrFail($id);
            $client->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            abort(404);
        }

        return ajaxResponse(
            [
                'message' => langapp('deleted_successfully'),
                'redirect' => route('clients.index'),
            ],
            true,
            Response::HTTP_OK
        );
    }
}
