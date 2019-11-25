<template>
  <loading-view 
    :loading="loading" 
    class="w-full">
    <display-row 
      v-if="!subscription" 
      class="text-70" 
      label="Status">
      There is no subscription available.
    </display-row>

    <display-row 
      v-if="subscription" 
      label="Plan">
      {{ subscription.plan }}
    </display-row>

    <display-row 
      v-if="subscription" 
      label="Subscribed since">
      {{ subscription.created_at }}
    </display-row>

    <display-row 
      v-if="subscription" 
      class="remove-bottom-border" 
      label="Status">
      <span v-if="subscription.on_grace_period">
        On Grace Period
      </span>
      <span 
        v-if="subscription.cancelled || subscription.ends_at" 
        class="text-danger">
        Cancelled
      </span>
      <span v-if="subscription.active && !subscription.cancelled && !subscription.ends_at">
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
