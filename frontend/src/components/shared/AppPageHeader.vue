<template>
  <div class="px-8 h-20 flex flex-col justify-center bg-white border-b border-gray-200">
    <h1 class="text-xl font-bold text-gray-900">{{ title }}</h1>
    <p class="text-sm text-gray-500 mt-0.5">
      <slot>{{ subtitle }}</slot>
    </p>
  </div>
</template>

<script setup>
defineProps({
  title:    { type: String, required: true },
  subtitle: { type: String, default: '' },
})
</script>
