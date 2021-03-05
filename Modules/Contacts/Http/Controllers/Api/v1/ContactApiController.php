<?php

namespace Modules\Contacts\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Clients\Entities\Client;
use Modules\Contacts\Http\Requests\ContactRequest;
use Modules\Contacts\Notifications\InviteContact;
use Modules\Contacts\Transformers\ContactResource;
use Modules\Contacts\Transformers\ContactsResource;
use Modules\Users\Entities\Profile;
use Modules\Users\Entities\User;
use Modules\Users\Jobs\BulkDeleteUsers;

class ContactApiController extends Controller
{
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('localize');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */

    public function index()
    {
        $contacts = new ContactsResource(Profile::with(['user:id,username,email,name', 'business:id,name,currency,expense,balance,paid,primary_contact'])->contacts()->orderBy('id', 'desc')->paginate(40));
        if ($this->request->has('json')) {
            $data['contacts'] = $contacts;
            return view('contacts::_ajax._contacts')->with($data);
        }
        return response($contacts, Response::HTTP_OK);
    }

    /**
     * Show the specified resource.
     *
     * @param  string $id
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id = null)
    {
        $contact = Profile::findOrFail($id);
        if (optional($contact)->company > 0) {
            return response(new ContactResource($contact), Response::HTTP_OK);
        }
        return response(['errors' => ['message' => 'User not linked to any company']], Response::HTTP_OK);
    }

    public function save(ContactRequest $request)
    {
        if (!isAdmin() && Auth::user()->profile->company != $request->company) {
            abort(401);
        }
        if ($request->has('company_email')) {
            $this->request->validate([
                'company_email' => 'required|email|unique:clients,email',
                'company_name' => 'required',
            ]);
        }
        if (!$request->has('password') || strlen($request->password) <= 0) {
            $request->request->add(['password' => randomPassword(8)]);
        }
        $user = User::create($request->except(['company', 'phone', 'invite']));
        $user->update(['email_verified_at' => config('system.verification') ? null : now()]);
        $user->profile->update($request->only(['company', 'phone']));
        if ($request->invite == 1) {
            $user->notify(new InviteContact($user, $request->password));
        }
        if (is_null($request->company) && $request->has('company_email')) {
            $client = Client::create([
                'name' => $request->company_name,
                'email' => $request->company_email,
                'primary_contact' => $user->id,
                'phone' => $request->phone,
            ]);
            $user->profile->update(['company' => $client->id]);
        }
        return ajaxResponse(
            [
                'id' => $user->id,
                'message' => langapp('saved_successfully'),
                'redirect' => $request->has('url') ? $request->url : route('clients.view', $user->profile->company),
            ],
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id = null)
    {
        $this->request->validate(
            [
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($id),
                    'email',
                ],
                'name' => 'required',
                'username' => [
                    'required',
                    Rule::unique('users')->ignore($id),
                ],
            ]
        );
        $this->checkPassword($this->request);
        $contact = User::findOrFail($id);
        $contact->update($this->request->only(['username', 'email', 'password', 'name']));
        $contact->profile->update($this->request->except(['id', 'username', 'password', 'email', 'name']));

        if ($this->request->invite == '1') {
            $contact->notify(new InviteContact($contact, $this->request->password));
        }

        return ajaxResponse(
            [
                'id' => $contact->id,
                'message' => langapp('changes_saved_successful'),
                'redirect' => route('contacts.view', $contact->id),
            ],
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id = null)
    {
        BulkDeleteUsers::dispatch([$id], \Auth::id())->onQueue('normal');
        return response(null, Response::HTTP_OK);
    }

    private function checkPassword($request)
    {
        if (config('system.secure_password')) {
            return $request->validate(['password' => 'sometimes|pwned']);
        }
        return;
    }
}
