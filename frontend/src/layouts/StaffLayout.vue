<template>
  <div class="flex min-h-screen bg-gray-50">
    <AppSidebar :nav-items="navItems" role-label="เจ้าหน้าที่" @logout="handleLogout" />
    <main class="flex-1 min-w-0 overflow-y-auto">
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import AppSidebar from '@/components/shared/AppSidebar.vue'
import { LayoutDashboard, ClipboardList } from '@lucide/vue'

const router = useRouter()
const auth   = useAuthStore()

const navItems = [
  { name: 'staff-home',   to: '/staff',        label: 'แดชบอร์ด',      icon: LayoutDashboard },
  { name: 'staff-review', to: '/staff/review', label: 'ตรวจสอบคำขอ',  icon: ClipboardList   },
]

function handleLogout() {
  auth.logout()
  router.push({ name: 'login' })
}
</script>
