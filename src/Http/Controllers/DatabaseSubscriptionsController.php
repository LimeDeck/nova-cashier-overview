<?php

namespace LimeDeck\NovaCashierOverview\Http\Controllers;

use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;

class DatabaseSubscriptionsController extends Controller
{
    /**
     * @param $billableId
     * @return array
     */
    public function show($billableId)
    {
        $customerModel = Cashier::$customerModel;

        /** @var \Illuminate\Database\Eloquent\Model $billableModel */
        $billableModel = (new $customerModel());

        /** @var \Laravel\Cashier\Billable|\Illuminate\Database\Eloquent\Model $billable */
        $billable = $billableModel->find($billableId);

        /** @var \Laravel\Cashier\Subscription $subscription */
        $subscription = $billable->subscription(
            $this->request->query('subscription', 'default')
        );

        if (! $subscription) {
            return [
                'subscription' => null,
            ];
        }

        return [
            'subscription' => $this->formatSubscription($subscription),
        ];
    }

    /**
     * @param  \Laravel\Cashier\Subscription  $subscription
     * @return array
     */
    protected function formatSubscription(Subscription $subscription)
    {
        return array_merge($subscription->toArray(), [
            'plan'            => $subscription->stripe_price,
            'ended'           => $subscription->ended(),
            'canceled'        => $subscription->canceled(),
            'active'          => $subscription->active(),
            'on_trial'        => $subscription->onTrial(),
            'on_grace_period' => $subscription->onGracePeriod(),
        ]);
    }
}
