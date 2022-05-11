<?php

namespace LimeDeck\NovaCashierOverview\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Subscription;
use Stripe\Plan;
use Stripe\Subscription as StripeSubscription;

class StripeSubscriptionsController extends Controller
{
    /**
     * @param $subscriptionId
     * @return array
     *
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function show($subscriptionId)
    {
        /** @var \Laravel\Cashier\Subscription $subscription */
        $subscription = Subscription::find($subscriptionId);

        if (! $subscription) {
            return [
                'subscription' => null,
            ];
        }

        return [
            'subscription' => $this->formatSubscription($subscription),
            'plans' => $this->formatPlans(Plan::all(['limit' => 100])),
            'invoices' => $this->formatInvoices($subscription->owner->invoicesIncludingPending()),
        ];
    }

    /**
     * @param $subscriptionId
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Laravel\Cashier\Exceptions\SubscriptionUpdateFailure
     */
    public function update($subscriptionId)
    {
        /** @var \Laravel\Cashier\Subscription $subscription */
        $subscription = Subscription::findOrFail($subscriptionId);

        $subscription->swap($this->request->input('plan'));

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $subscriptionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel($subscriptionId)
    {
        /** @var \Laravel\Cashier\Subscription $subscription */
        $subscription = Subscription::findOrFail($subscriptionId);

        if ($this->request->input('now')) {
            $subscription->cancelNow();
        } else {
            $subscription->cancel();
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $subscriptionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function resume($subscriptionId)
    {
        /** @var \Laravel\Cashier\Subscription $subscription */
        $subscription = Subscription::findOrFail($subscriptionId);

        $subscription->resume();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param  \Laravel\Cashier\Subscription  $subscription
     * @return array
     *
     * @throws \Stripe\Exception\ApiErrorException
     */
    protected function formatSubscription(Subscription $subscription)
    {
        $stripeSubscription = StripeSubscription::retrieve($subscription->stripe_id);

        return array_merge($subscription->toArray(), [
            'plan_amount' => $stripeSubscription->plan->amount,
            'plan_interval' => $stripeSubscription->plan->interval,
            'plan_currency' => $stripeSubscription->plan->currency,
            'plan' => $subscription->stripe_plan,
            'stripe_plan' => $stripeSubscription->plan->id,
            'ended' => $subscription->ended(),
            'cancelled' => $subscription->cancelled(),
            'active' => $subscription->active(),
            'on_trial' => $subscription->onTrial(),
            'on_grace_period' => $subscription->onGracePeriod(),
            'charges_automatically' => $stripeSubscription->billing == 'charge_automatically',
            'created_at' => $this->formatDate($stripeSubscription->billing_cycle_anchor),
            'ended_at' => $this->formatDate($stripeSubscription->ended_at),
            'current_period_start' => $this->formatDate($stripeSubscription->current_period_start),
            'current_period_end' => $this->formatDate($stripeSubscription->current_period_end),
            'days_until_due' => $stripeSubscription->days_until_due,
            'cancel_at_period_end' => $stripeSubscription->cancel_at_period_end,
            'canceled_at' => $stripeSubscription->canceled_at,
        ]);
    }

    /**
     * Format the plans collection.
     *
     * @param  \Stripe\Collection  $plans
     * @return array
     */
    protected function formatPlans($plans)
    {
        return collect($plans->data)->map(function (Plan $plan) {
            return [
                'id' => $plan->id,
                'price' => $plan->amount,
                'interval' => $plan->interval,
                'currency' => $plan->currency,
                'interval_count' => $plan->interval_count,
            ];
        })->toArray();
    }

    /**
     * @param $invoices
     * @return array
     */
    protected function formatInvoices($invoices)
    {
        return collect($invoices)->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'total' => $invoice->total,
                'attempted' => $invoice->attempted,
                'charge_id' => $invoice->charge,
                'currency' => $invoice->currency,
                'period_start' => $this->formatDate($invoice->period_start),
                'period_end' => $this->formatDate($invoice->period_end),
                'link' => $invoice->hosted_invoice_url,
                'subscription' => $invoice->subscription,
            ];
        })->toArray();
    }

    /**
     * @param  mixed  $value
     * @return string|null
     */
    protected function formatDate($value)
    {
        return $value ? Carbon::createFromTimestamp($value)->toDateTimeString() : null;
    }
}
