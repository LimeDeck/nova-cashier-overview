<template>
  <div>
    <h1 class="text-90 mb-3 text-2xl font-normal">
      Subscription <span class="text-70 font-light">({{ subscriptionName }})</span>
    </h1>

    <card class="mb-6 flex flex-col py-3 px-6">
      <database-details :subscription="databaseSubscription" :loading="loading.database" />

      <stripe-details
        v-if="databaseSubscription"
        :subscription="stripeSubscription"
        :invoices="invoices"
        :plans="plans"
        :loading="loading.stripe"
        @manage-clicked="fetchStripeSubscription"
        @update-plan="updatePlan"
        @cancel-subscription="cancelSubscription"
        @resume-subscription="resumeSubscription"
      />
    </card>
  </div>
</template>

<script>
import DatabaseDetails from './DatabaseDetails';
import StripeDetails from './StripeDetails';

export default {
  components: {
    DatabaseDetails,
    StripeDetails,
  },

  props: {
    resourceName: {
      type: String,
      default: '',
    },
    resourceId: {
      type: [String, Number],
      default: '',
    },
    panel: {
      type: Object,
      default: () => ({}),
    },
  },

  data: () => ({
    baseEndpoint: '/nova-vendor/nova-cashier-overview/',
    loading: {
      database: true,
      stripe: false,
    },
    databaseSubscription: null,
    stripeSubscription: null,
    invoices: [],
    plans: [],
  }),

  computed: {
    subscriptionName() {
      return this.panel.fields[0].subscription || 'default';
    },
  },

  mounted() {
    this.fetchDatabaseSubscription();
  },

  methods: {
    fetchDatabaseSubscription() {
      Nova.request()
        .get(
          `${this.baseEndpoint}billable/${this.resourceId}/?subscription=${this.subscriptionName}`
        )
        .then((res) => {
          this.databaseSubscription = res.data.subscription;
          this.loading.database = false;
        });
    },

    fetchStripeSubscription() {
      this.loading.stripe = true;

      Nova.request()
        .get(`${this.baseEndpoint}subscriptions/${this.databaseSubscription.id}`)
        .then((res) => {
          this.stripeSubscription = res.data.subscription;
          this.invoices = res.data.invoices;
          this.plans = res.data.plans;
          this.loading.stripe = false;
        });
    },

    updatePlan(newPlan) {
      this.loading.stripe = true;

      Nova.request()
        .put(`${this.baseEndpoint}subscriptions/${this.databaseSubscription.id}`, {
          plan: newPlan,
        })
        .then(() => {
          Nova.success('Updated successfully!');

          this.fetchStripeSubscription();
        })
        .catch((err) => {
          Nova.error(err.response.data.message);
        });
    },

    resumeSubscription() {
      this.loading.stripe = true;
      this.loading.database = true;

      Nova.request()
        .post(`${this.baseEndpoint}subscriptions/${this.databaseSubscription.id}/resume`)
        .then(() => {
          Nova.success('Resumed successfully!');

          this.fetchDatabaseSubscription();
          this.fetchStripeSubscription();
        })
        .catch((err) => {
          Nova.error(err.response.data.message);
        });
    },

    cancelSubscription() {
      this.loading.stripe = true;
      this.loading.database = true;

      Nova.request()
        .post(`${this.baseEndpoint}subscriptions/${this.databaseSubscription.id}/cancel`)
        .then(() => {
          Nova.success('Cancelled successfully!');

          this.fetchDatabaseSubscription();
          this.fetchStripeSubscription();
        })
        .catch((err) => {
          Nova.error(err.response.data.message);
        });
    },
  },
};
</script>
