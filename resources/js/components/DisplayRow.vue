<template>
  <div
    class="-mx-6 flex flex-col space-y-2 px-6 py-2 md:flex-row md:space-y-0 md:py-0"
    :class="{ 'border-t border-gray-100 dark:border-gray-700': !isFirst }"
  >
    <div class="md:w-1/4 md:py-3">
      <h4 class="font-bold md:font-normal">
        <span>{{ label }}</span>
      </h4>
    </div>
    <div class="break-words md:w-3/4 md:py-3">
      <p class="text-90">
        <slot></slot>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DisplayRow',

  props: {
    label: {
      type: String,
      required: true,
    },
    isFirst: {
      type: Boolean,
      default: false,
    },
  },
};
</script>
