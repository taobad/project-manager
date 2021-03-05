<?php
namespace Modules\Webhook\Http\Controllers;

use Illuminate\Support\Carbon;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Laravel\Cashier\Subscription;

class StripeWebhookController extends CashierController
{
    /**
     * Handle customer subscription updated.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $data = $payload['data']['object'];

            $user->subscriptions->filter(function (Subscription $subscription) use ($data) {
                return $subscription->stripe_id === $data['id'];
            })->each(function (Subscription $subscription) use ($data) {
                if (isset($data['status']) && $data['status'] === 'incomplete_expired') {
                    $subscription->delete();

                    return;
                }

                // Quantity...
                if (isset($data['quantity'])) {
                    $subscription->quantity = $data['quantity'];
                }

                // Plan...
                if (isset($data['plan']['id'])) {
                    $subscription->stripe_plan = $data['plan']['id'];
                }

                // Trial ending date...
                if (isset($data['trial_end'])) {
                    $trial_ends = Carbon::createFromTimestamp($data['trial_end']);

                    if (!$subscription->trial_ends_at || $subscription->trial_ends_at->ne($trial_ends)) {
                        $subscription->trial_ends_at = $trial_ends;
                    }
                }

                // Cancellation date...
                if (isset($data['cancel_at_period_end'])) {
                    $subscription->ends_at = null;
                    if ($data['cancel_at_period_end']) {
                        $subscription->ends_at = $subscription->onTrial()
                        ? $subscription->trial_ends_at
                        : Carbon::createFromTimestamp($data['current_period_end']);
                    }
                }

                // Status...
                if (isset($data['status'])) {
                    if ($data['status'] != 'active') {
                        foreach ($subscription->owner->contacts as $profile) {
                            $profile->user->removeRole('subscriber_' . strtolower($subscription->name));
                        }
                    }
                    $subscription->stripe_status = $data['status'];
                }

                $subscription->save();

                // Update subscription items...
                if (isset($data['items'])) {
                    $plans = [];

                    foreach ($data['items']['data'] as $item) {
                        $plans[] = $item['plan']['id'];

                        $subscription->items()->updateOrCreate([
                            'stripe_id' => $item['id'],
                        ], [
                            'stripe_plan' => $item['plan']['id'],
                            'quantity' => $item['quantity'],
                        ]);
                    }

                    // Delete items that aren't attached to the subscription anymore...
                    $subscription->items()->whereNotIn('stripe_plan', $plans)->delete();
                }

            });
        }

        return $this->successMethod();
    }
}
