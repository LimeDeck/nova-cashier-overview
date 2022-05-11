<template>
  <div class="relative mt-8">
    <div class="border-50 flex items-center border-b py-3">
      <div class="px-3">Invoices</div>
    </div>

    <div class="relative overflow-hidden overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <th
              v-for="item in columns"
              :key="item.label"
              class="text-xxs border-r border-gray-200 py-2 px-6 uppercase tracking-wide text-gray-500 dark:border-gray-600"
            >
              {{ item.label }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="invoice in invoices" :key="invoice.id" class="group">
            <td
              class="border-t border-gray-100 px-6 py-2 group-hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:group-hover:bg-gray-900"
            >
              {{ invoice.charge_id || '-' }}
            </td>
            <td
              class="border-t border-gray-100 py-2 group-hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:group-hover:bg-gray-900"
            >
              {{ invoice.total / 100 }} {{ invoice.currency }}
            </td>
            <td
              class="border-t border-gray-100 px-6 py-2 group-hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:group-hover:bg-gray-900"
            >
              {{ invoice.period_start }}
            </td>
            <td
              class="border-t border-gray-100 px-6 py-2 group-hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:group-hover:bg-gray-900"
            >
              {{ invoice.period_end }}
            </td>
            <td
              class="mx-auto border-t border-gray-100 px-6 py-2 text-center group-hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:group-hover:bg-gray-900"
            >
              <a
                v-if="invoice.link"
                :href="invoice.link"
                class="bg-primary-500 hover:bg-primary-400 active:bg-primary-600 inline-flex h-9 flex-shrink-0 flex-shrink-0 items-center rounded px-4 text-sm font-bold text-white shadow focus:outline-none focus:ring dark:text-gray-800"
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
