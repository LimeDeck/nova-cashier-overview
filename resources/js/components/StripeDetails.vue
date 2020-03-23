<template>
  <loading-view :loading="loading" class="w-full">
    <div v-if="!subscription" class="flex py-8">
      <button
        class="mx-auto btn btn-default bg-30 border-30 font-normal hover:bg-40"
        @click="$emit('manage-clicked')"
      >
        {{ __('Manage Stripe subscription') }}
      </button>
    </div>

    <div v-if="!loading && subscription">
      <heading class="mt-8 mb-4">
        {{ __('Stripe subscription management') }}
      </heading>

      <display-row v-if="subscription" :label="__('Created')">
        {{ subscription.created_at | moment(__('DD.MM.YYYY HH:mm')) }}
      </display-row>

      <display-row v-if="subscription" :label="__('Plan')">
        {{ __(subscription.stripe_plan) }}
      </display-row>

      <display-row v-if="subscription" :label="__('Change plan')">
        <select v-model="newPlan" class="form-control form-select">
          <option value="" disabled="disabled" selected="selected">
            {{ __('Choose new plan') }}
          </option>
          <option v-for="plan in plans" :key="plan.id" :value="plan.id">
            {{ __(plan.id) }} ({{ plan.price / 100 }} {{ plan.currency }} / {{ __(plan.interval) }})
          </option>
        </select>

        <button
          v-if="
            newPlan &&
              newPlan != subscription.stripe_plan &&
              subscription.active &&
              !subscription.cancel_at_period_end
          "
          class="btn btn-sm btn-outline"
          @click="$emit('update-plan', newPlan)"
        >
          {{ __('Update Plan') }}
        </button>
      </display-row>

      <display-row v-if="subscription" :label="__('Amount')">
        {{ subscription.plan_amount / 100 }} ({{ subscription.plan_currency }}) /
        {{ __(subscription.plan_interval) }}
      </display-row>

      <display-row v-if="subscription" :label="__('Billing period')">
        {{ subscription.current_period_start | moment(__('DD.MM.YYYY HH:mm')) }} {{ __('to') }}
        {{ subscription.current_period_end | moment(__('DD.MM.YYYY HH:mm')) }}
      </display-row>

      <display-row v-if="subscription" :label="__('Status')">
        <span v-if="subscription.on_grace_period">On Grace Period</span>
        <span
          v-if="subscription.cancelled || subscription.cancel_at_period_end"
          class="text-danger"
          >{{ __('Cancelled') }}</span
        >
        <span
          v-if="
            subscription.active && !subscription.cancelled && !subscription.cancel_at_period_end
          "
          >{{ __('Active') }}</span
        >

        <button
          v-if="
            subscription.active && !subscription.cancelled && !subscription.cancel_at_period_end
          "
          class="btn btn-sm btn-outline ml-4"
          @click="$emit('cancel-subscription')"
        >
          {{ __('Cancel') }}
        </button>

        <button
          v-if="subscription.active && subscription.cancel_at_period_end"
          class="btn btn-sm btn-outline ml-4"
          @click="$emit('resume-subscription')"
        >
          {{ __('Resume') }}
        </button>
      </display-row>
    </div>

    <invoices-table v-if="invoices.length" :invoices="invoices" />
  </loading-view>
</template>

<script>
import DisplayRow from './DisplayRow';
import InvoicesTable from './InvoicesTable';

import moment from 'moment';

export default {
  filters: {
    moment: function(date, format) {
      return moment(date).format(format);
    },
  },
  name: 'StripeDetails',

  components: {
    DisplayRow,
    InvoicesTable,
  },

  props: {
    loading: {
      type: Boolean,
      default: true,
    },
    subscription: {
      type: Object,
      default: null,
    },
    invoices: {
      type: Array,
      default: () => [],
    },
    plans: {
      type: Array,
      default: () => [],
    },
  },

  data: () => ({
    newPlan: '',
  }),
};
</script>
