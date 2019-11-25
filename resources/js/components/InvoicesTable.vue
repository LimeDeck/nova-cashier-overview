<template>
  <div class="mt-8 relative">
    <div class="py-3 flex items-center border-b border-50">
      <div class="px-3">
        Invoices
      </div>
    </div>

    <div class="overflow-hidden overflow-x-auto relative">
      <table 
        cellpadding="0" 
        cellspacing="0" 
        data-testid="resource-table" 
        class="table w-full">
        <thead>
          <tr>
            <th 
              v-for="item in columns" 
              :key="item.label" 
              class="text-left">
              <span class="cursor-pointer inline-flex items-center">
                {{ item.label }}
              </span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr 
            v-for="invoice in invoices" 
            :key="invoice.id">
            <td>
              <span class="whitespace-no-wrap text-left">
                {{ invoice.charge_id || '-' }}
              </span>
            </td>
            <td>
              <span class="whitespace-no-wrap text-left">
                {{ invoice.total / 100 }} {{ invoice.currency }}
              </span>
            </td>
            <td>
              <span class="whitespace-no-wrap text-left">
                {{ invoice.period_start }}
              </span>
            </td>
            <td>
              <span class="whitespace-no-wrap text-left">
                {{ invoice.period_end }}
              </span>
            </td>
            <td class="text-right">
              <a
                v-if="invoice.link"
                :href="invoice.link"
                class="btn btn-outline text-sm"
                target="_blank"
              >
                View
              </a>
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

  data: () => ({
    columns: [
      { label: 'Charge ID' },
      { label: 'Amount' },
      { label: 'From' },
      { label: 'To' },
      { label: 'Actions' },
    ],
  }),
};
</script>

<style scoped></style>
