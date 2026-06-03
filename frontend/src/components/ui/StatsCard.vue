<template>
  <div class="stats-card" :class="`stats-card--${variant}`">
    <div class="stats-icon">
      <slot name="icon" />
    </div>
    <div class="stats-body">
      <p class="stats-label">{{ label }}</p>
      <p class="stats-value">{{ value }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  label:   { type: String,  required: true },
  value:   { type: Number,  required: true },
  variant: { type: String,  default: 'default' },
})
</script>

<style scoped>
.stats-card {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1.25rem 1.5rem;
  border-radius: 10px;
  border: 1px solid #f3f4f6;
  background: #fff;
  flex: 1;
}
.stats-card--pending  { background: #fefce8; border-color: #fef08a; }
.stats-card--approved { background: #f0fdf4; border-color: #bbf7d0; }
.stats-card--rejected { background: #fef2f2; border-color: #fecaca; }

.stats-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: rgba(0,0,0,0.05);
  flex-shrink: 0;
}
.stats-label {
  font-size: 0.8rem;
  color: #6b7280;
  margin: 0;
}
.stats-value {
  font-size: 1.6rem;
  font-weight: 700;
  color: #111827;
  margin: 0;
  line-height: 1.2;
}
</style>
