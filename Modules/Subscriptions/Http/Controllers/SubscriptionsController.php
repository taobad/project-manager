<?php

namespace Modules\Subscriptions\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Modules\Subscriptions\Entities\CustomSubscription;
use Modules\Subscriptions\Entities\SubscriptionPlan;
use Spatie\Permission\Models\Role;
use Stripe\Plan;
use Stripe\Stripe;

class SubscriptionsController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware(['auth', 'verified', '2fa', 'can:menu_subscriptions']);
        $this->request = $request;
    }
    public function index()
    {
        $data['page'] = $this->getPage();
        $data['filter'] = request('filter', 'all');
        return view('subscriptions::index')->with($data);
    }

    public function invoices()
    {
        $data['page'] = $this->getPage();
        return view('subscriptions::invoices')->with($data);
    }

    public function subscribe(SubscriptionPlan $plan)
    {
        if (is_null(Auth::user()->profile->business)) {
            abort(403);
        }
        $data['page'] = $this->getPage();
        $data['plan'] = $plan;
        Stripe::setApiKey(config('cashier.secret'));
        $data['subscription'] = array_first(
            Plan::all()->data,
            function ($item) use ($plan) {
                return $item->id == $plan->stripe_plan_id;
            }
        );
        $data['subscribed'] = Auth::user()->profile->business->subscribed($plan->stripe_plan_id);
        $data['intent'] = Auth::user()->profile->business->createSetupIntent();
        return view('subscriptions::subscribe')->with($data);
    }

    public function cancel(SubscriptionPlan $plan)
    {
        $data['subscription'] = Auth::user()->profile->business->subscriptions()->where('name', $plan->name)->first();
        return view('subscriptions::modal.cancel')->with($data);
    }

    public function activate(SubscriptionPlan $plan)
    {
        $subscription = Auth::user()->profile->business->subscriptions()->where('name', $plan->name)->first();
        Auth::user()->profile->business->subscription($subscription->name)->resume();
        Auth::user()->assignRole('subscriber_' . strtolower($subscription->name));
        toastr()->success(langapp('changes_saved_successful'), langapp('response_status'));

        return redirect()->route('subscriptions.index');
    }

    public function deactivate()
    {
        $this->request->validate(['id' => 'required|numeric']);
        $subscription = Auth::user()->profile->business->subscriptions()->where('id', $this->request->id)->first();
        if ($this->request->cancel_immediately == 1) {
            Auth::user()->profile->business->subscription($subscription->name)->cancelNow();
        } else {
            Auth::user()->profile->business->subscription($subscription->name)->cancel();
        }
        Auth::user()->removeRole('subscriber_' . strtolower($subscription->name));
        $data['message'] = langapp('changes_saved_successful');
        $data['redirect'] = route('subscriptions.index');

        return ajaxResponse($data, true, Response::HTTP_OK);
    }

    public function adminCancel($id)
    {
        $data['subscription'] = CustomSubscription::where('id', $id)->first();
        return view('subscriptions::modal.admin_cancel')->with($data);
    }
    public function adminActivate($id)
    {
        $subscription = CustomSubscription::where('id', $id)->first();
        $subscription->owner->subscription($subscription->name)->resume();
        if ($subscription->owner->primary_contact) {
            $subscription->owner->contact->assignRole('subscriber_' . strtolower($subscription->name));
        }
        toastr()->success(langapp('changes_saved_successful'), langapp('response_status'));
        return redirect()->route('subscriptions.index');
    }
    public function adminDeactivate()
    {
        $this->request->validate(['id' => 'required|numeric']);
        $subscription = CustomSubscription::where('id', $this->request->id)->first();
        if ($this->request->cancel_immediately == 1) {
            $subscription->owner->subscription($subscription->name)->cancelNow();
            if ($subscription->owner->primary_contact) {
                $subscription->owner->contact->removeRole('subscriber_' . strtolower($subscription->name));
            }
        } else {
            $subscription->owner->subscription($subscription->name)->cancel();
        }
        $data['message'] = langapp('changes_saved_successful');
        $data['redirect'] = route('subscriptions.index');

        return ajaxResponse($data, true, Response::HTTP_OK);
    }

    public function process()
    {
        $paymentMethod = $this->request->paymentMethod;
        $billingDate = strtotime($this->request->billing_date) > time() ? Carbon::parse($this->request->billing_date) : now()->addMinutes(5);
        Auth::user()->profile->business->createOrGetStripeCustomer();
        Auth::user()->profile->business->updateDefaultPaymentMethod($paymentMethod);
        try {
            Auth::user()->profile->business->newSubscription($this->request->name, $this->request->plan)
                ->trialUntil($billingDate)
                ->withCoupon($this->request->coupon)
                ->create($paymentMethod);

            $role = Role::firstOrCreate(['name' => 'subscriber_' . strtolower($this->request->name)]);
            Auth::user()->assignRole($role->name);
            return redirect(route('subscriptions.index'));
        } catch (IncompletePayment $exception) {
            Log::error($exception->getMessage());
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('home')]
            );
        }
    }

    private function getPage()
    {
        return langapp('subscriptions');
    }
}
