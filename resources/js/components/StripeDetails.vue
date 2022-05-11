<template>
  <loading-view :loading="loading" class="w-full">
    <div v-if="!subscription" class="flex justify-center py-8">
      <button
        class="bg-primary-500 hover:bg-primary-400 active:bg-primary-600 mt-2 ml-4 inline-flex h-9 flex-shrink-0 items-center rounded px-4 text-sm font-bold text-white shadow focus:outline-none focus:ring dark:text-gray-800"
        @click="$emit('manage-clicked')"
      >
        Manage Stripe subscription
      </button>
    </div>

    <div v-if="!loading && subscription">
      <heading class="mt-8 mb-4"> Stripe subscription management</heading>

      <display-row v-if="subscription" label="Created">
        {{ subscription.created_at }}
      </display-row>

      <display-row v-if="subscription" label="Plan">
        {{ subscription.stripe_plan }}
      </display-row>

      <display-row v-if="subscription" label="Change plan" class="relative flex">
        <select v-model="newPlan" class="form-control form-select-bordered form-select block">
          <option value="" disabled="disabled" selected="selected">Choose New Plan</option>
          <option v-for="plan in plans" :key="plan.id" :value="plan.id">
            {{ plan.id }} ({{ plan.price / 100 }} {{ plan.currency }} / {{ plan.interval }})
          </option>
        </select>

        <button
          v-if="
            newPlan &&
            newPlan != subscription.stripe_plan &&
            subscription.active &&
            !subscription.cancel_at_period_end
          "
          class="bg-primary-500 hover:bg-primary-400 active:bg-primary-600 mt-2 inline-flex h-9 flex-shrink-0 flex-shrink-0 items-center rounded px-4 text-sm font-bold text-white shadow focus:outline-none focus:ring dark:text-gray-800"
          @click="$emit('update-plan', newPlan)"
        >
          Update Plan
        </button>
      </display-row>

      <display-row v-if="subscription" label="Amount">
        {{ subscription.plan_amount / 100 }} ({{ subscription.plan_currency }}) /
        {{ subscription.plan_interval }}
      </display-row>

      <display-row v-if="subscription" label="Billing period">
        {{ subscription.current_period_start }} => {{ subscription.current_period_end }}
      </display-row>

      <display-row v-if="subscription" label="Status">
        <span v-if="subscription.on_grace_period">On Grace Period</span>
        <span
          v-if="subscription.cancelled || subscription.cancel_at_period_end"
          class="ml-4 text-red-600 dark:text-red-400"
          >Cancelled</span
        >
        <span
          v-if="
            subscription.active && !subscription.cancelled && !subscription.cancel_at_period_end
          "
          class="text-green-600 dark:text-green-400"
          >Active</span
        >

        <button
          v-if="
            subscription.active && !subscription.cancelled && !subscription.cancel_at_period_end
          "
          class="mt-2 ml-4 inline-flex h-9 flex-shrink-0 flex-shrink-0 items-center rounded bg-red-500 px-4 text-sm font-bold text-white shadow hover:bg-red-300 focus:outline-none focus:ring active:bg-red-600 dark:text-gray-800"
          @click="$emit('cancel-subscription')"
        >
          Cancel
        </button>

        <button
          v-if="subscription.active && subscription.cancel_at_period_end"
          class="bg-primary-500 hover:bg-primary-400 active:bg-primary-600 mt-2 ml-4 inline-flex h-9 flex-shrink-0 flex-shrink-0 items-center rounded px-4 text-sm font-bold text-white shadow focus:outline-none focus:ring dark:text-gray-800"
          @click="$emit('resume-subscription')"
        >
          Resume
        </button>
      </display-row>
    </div>

    <invoices-table v-if="invoices.length" :invoices="invoices" />
  </loading-view>
</template>

<script>
import DisplayRow from './DisplayRow';
import InvoicesTable from './InvoicesTable';

export default {
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
