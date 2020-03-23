<template>
  <loading-view :loading="loading" class="w-full">
    <display-row v-if="!subscription" class="text-70" label="Status">{{
      __('No active subscription')
    }}</display-row>

    <display-row v-if="subscription" :label="__('Plan')">{{ subscription.plan }}</display-row>

    <display-row v-if="subscription" :label="__('Subscribed since')">
      {{ subscription.created_at | moment(__('DD.MM.YYYY HH:mm')) }}
    </display-row>

    <display-row v-if="subscription" class="remove-bottom-border" :label="__('Status')">
      <span v-if="subscription.on_grace_period">{{ __('On Grace Period') }}</span>
      <span v-if="subscription.cancelled || subscription.ends_at" class="text-danger">
        {{ __('Cancelled') }}</span
      >
      <span v-if="subscription.active && !subscription.cancelled && !subscription.ends_at">{{
        __('Active')
      }}</span>
    </display-row>
  </loading-view>
</template>

<script>
import DisplayRow from './DisplayRow';
import moment from 'moment';

export default {
  filters: {
    moment: function(date, format) {
      return moment(date).format(format);
    },
  },
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
