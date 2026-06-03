<template>
  <aside class="w-52 min-h-screen bg-white border-r border-gray-200 flex flex-col flex-shrink-0">

    <!-- Logo -->
    <div class="flex items-center gap-3 px-4 h-20 border-b border-gray-200">
      <div class="w-9 h-9 bg-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="16" y1="13" x2="8" y2="13"/>
          <line x1="16" y1="17" x2="8" y2="17"/>
        </svg>
      </div>
      <div>
        <p class="text-sm font-bold text-gray-900 leading-tight">CoopMS</p>
        <p class="text-xs text-gray-400 leading-tight">ระบบจัดการสหกรณ์</p>
      </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-3 py-4 flex flex-col gap-1">
      <RouterLink
        v-for="item in navItems"
        :key="item.to"
        :to="item.to"
        class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
        :class="route.name === item.name
          ? 'bg-primary-50 text-primary-600'
          : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800'"
      >
        <component :is="item.icon" :size="17" />
        {{ item.label }}
      </RouterLink>
    </nav>

    <!-- User -->
    <div class="flex items-center gap-2.5 px-4 py-3 border-t border-gray-100">
      <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
        {{ initials }}
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-xs font-semibold text-gray-800 truncate">{{ auth.user?.name ?? 'ผู้ใช้งาน' }}</p>
        <p class="text-xs text-gray-400">{{ roleLabel }}</p>
      </div>
      <button
        @click="$emit('logout')"
        title="ออกจากระบบ"
        class="p-1 rounded text-gray-400 hover:text-red-500 transition-colors"
      >
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
      </button>
    </div>

  </aside>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

defineProps({
  navItems:  { type: Array,  required: true },
  roleLabel: { type: String, default: 'ผู้ใช้ทั่วไป' },
})

defineEmits(['logout'])

const route = useRoute()
const auth  = useAuthStore()

const initials = computed(() => {
  const name = auth.user?.name ?? ''
  return name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase() || 'U'
})
</script>
