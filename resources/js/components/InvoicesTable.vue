<template>
  <div class="mt-8 relative">
    <div class="py-3 flex items-center border-b border-50">
      <div class="px-3">{{ __('Invoices') }}</div>
    </div>

    <div class="overflow-hidden overflow-x-auto relative">
      <table cellpadding="0" cellspacing="0" data-testid="resource-table" class="table w-full">
        <thead>
          <tr>
            <th class="text-left">
              <span class="cursor-pointer inline-flex items-center">{{ __('Charge ID') }}</span>
            </th>
            <th class="text-left">
              <span class="cursor-pointer inline-flex items-center">{{ __('Amount') }}</span>
            </th>
            <th class="text-left">
              <span class="cursor-pointer inline-flex items-center">{{ __('Period Start') }}</span>
            </th>
            <th class="text-left">
              <span class="cursor-pointer inline-flex items-center">{{ __('Period End') }}</span>
            </th>
            <th class="text-left">
              <span class="cursor-pointer inline-flex items-center">{{ __('View') }}</span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="invoice in invoices" :key="invoice.id">
            <td>
              <span class="whitespace-no-wrap text-left">{{ invoice.charge_id || '-' }}</span>
            </td>
            <td>
              <span class="whitespace-no-wrap text-left"
                >{{ invoice.total / 100 }} {{ invoice.currency }}</span
              >
            </td>
            <td>
              <span class="whitespace-no-wrap text-left">{{ invoice.period_start }}</span>
            </td>
            <td>
              <span class="whitespace-no-wrap text-left">{{ invoice.period_end }}</span>
            </td>
            <td class="text-right">
              <a
                v-if="invoice.link"
                :href="invoice.link"
                class="btn btn-outline text-sm"
                target="_blank"
                >{{ __('View') }}</a
              >
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'InvoicesTable',

  props: {
    invoices: {
      type: Array,
      default: () => [],
    },
  },
};
</script>

<style scoped></style>
