<template>
  <loading-view 
    :loading="loading" 
    class="w-full">
    <div 
      v-if="!subscription" 
      class="flex py-8">
      <button
        class="mx-auto btn btn-default bg-30 border-30 font-normal hover:bg-40"
        @click="$emit('manage-clicked')"
      >
        Manage Stripe subscription
      </button>
    </div>

    <div v-if="!loading && subscription">
      <heading class="mt-8 mb-4">
        Stripe subscription management
      </heading>

      <display-row 
        v-if="subscription" 
        label="Created">
        {{ subscription.created_at }}
      </display-row>

      <display-row 
        v-if="subscription" 
        label="Plan">
        {{ subscription.stripe_plan }}
      </display-row>

      <display-row 
        v-if="subscription" 
        label="Change plan">
        <select 
          v-model="newPlan" 
          class="form-control form-select">
          <option 
            value="" 
            disabled="disabled" 
            selected="selected">Choose New Plan</option>
          <option 
            v-for="plan in plans" 
            :key="plan.id" 
            :value="plan.id">
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
          class="btn btn-sm btn-outline"
          @click="$emit('update-plan', newPlan)"
        >
          Update Plan
        </button>
      </display-row>

      <display-row 
        v-if="subscription" 
        label="Amount">
        {{ subscription.plan_amount / 100 }} ({{ subscription.plan_currency }}) /
        {{ subscription.plan_interval }}
      </display-row>

      <display-row 
        v-if="subscription" 
        label="Billing period">
        {{ subscription.current_period_start }} => {{ subscription.current_period_end }}
      </display-row>

      <display-row 
        v-if="subscription" 
        label="Status">
        <span v-if="subscription.on_grace_period">On Grace Period</span>
        <span 
          v-if="subscription.cancelled || subscription.cancel_at_period_end" 
          class="text-danger"
        >Cancelled</span
        >
        <span
          v-if="
            subscription.active && !subscription.cancelled && !subscription.cancel_at_period_end
          "
        >Active</span
        >

        <button
          v-if="
            subscription.active && !subscription.cancelled && !subscription.cancel_at_period_end
          "
          class="btn btn-sm btn-outline ml-4"
          @click="$emit('cancel-subscription')"
        >
          Cancel
        </button>

        <button
          v-if="subscription.active && subscription.cancel_at_period_end"
          class="btn btn-sm btn-outline ml-4"
          @click="$emit('resume-subscription')"
        >
          Resume
        </button>
      </display-row>
    </div>

    <invoices-table 
      v-if="invoices.length" 
      :invoices="invoices" />
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
