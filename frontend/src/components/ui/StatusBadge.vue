<template>
  <span class="badge" :class="variant">{{ label }}</span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  status: { type: String, required: true },
})

const map = {
  approved:  { label: 'อนุมัติแล้ว',     variant: 'badge--approved' },
  rejected:  { label: 'ถูกปฏิเสธ',       variant: 'badge--rejected' },
  pending:   { label: 'รอดำเนินการ',     variant: 'badge--pending' },
}

const label   = computed(() => map[props.status]?.label   ?? props.status)
const variant = computed(() => map[props.status]?.variant ?? '')
</script>

<style scoped>
.badge {
  display: inline-block;
  padding: 0.2rem 0.65rem;
  border-radius: 999px;
  font-size: 0.8rem;
  font-weight: 500;
}
.badge--approved {
  background: #dcfce7;
  color: #16a34a;
}
.badge--rejected {
  background: #fee2e2;
  color: #dc2626;
}
.badge--pending {
  background: #fef9c3;
  color: #ca8a04;
}
</style>
