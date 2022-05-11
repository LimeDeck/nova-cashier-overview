<template>
  <loading-view :loading="loading" class="w-full">
    <display-row v-if="!subscription" :is-first="true" class="text-70" label="Status">
      There is no subscription available.
    </display-row>

    <display-row v-if="subscription" label="Plan">
      {{ subscription.plan }}
    </display-row>

    <display-row v-if="subscription" label="Subscribed since">
      {{ subscription.created_at }}
    </display-row>

    <display-row v-if="subscription" class="remove-bottom-border" label="Status">
      <span v-if="subscription.on_grace_period"> On Grace Period </span>
      <span
        v-if="subscription.cancelled || subscription.ends_at"
        class="ml-4 text-red-600 dark:text-red-400"
      >
        Cancelled
      </span>
      <span
        v-if="subscription.active && !subscription.cancelled && !subscription.ends_at"
        class="text-green-600 dark:text-green-400"
      >
        Active
      </span>
    </display-row>
  </loading-view>
</template>

<script>
import DisplayRow from './DisplayRow';

export default {
  name: 'DatabaseDetails',

  components: {
    DisplayRow,
  },

  props: {
    loading: {
      type: Boolean,
      default: true,
    },
    showManageButton: {
      type: Boolean,
      default: true,
    },
    subscription: {
      type: Object,
      default: null,
    },
  },
};
</script>
