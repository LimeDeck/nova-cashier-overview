<template functional>
  <div 
    :class="data.staticClass" 
    class="flex border-b border-40">
    <div class="w-1/4 py-4">
      <h4 class="font-normal text-80">
        {{ props.label }}
      </h4>
    </div>
    <div class="w-3/4 py-4">
      <p class="text-90">
        <slot />
      </p>
    </div>
  </div>
</template>
