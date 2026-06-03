<template>
  <div class="flex min-h-screen bg-gray-50">
    <AppSidebar :nav-items="navItems" role-label="ผู้ใช้ทั่วไป" @logout="handleLogout" />
    <main class="flex-1 min-w-0 overflow-y-auto">
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import AppSidebar from '@/components/shared/AppSidebar.vue'
import { LayoutDashboard, FileText, PlusCircle } from '@lucide/vue'

const router = useRouter()
const auth   = useAuthStore()

const navItems = [
  { name: 'home',        to: '/',            label: 'แดชบอร์ด',     icon: LayoutDashboard },
  { name: 'my-requests', to: '/my-requests', label: 'คำขอของฉัน',   icon: FileText        },
  { name: 'new-request', to: '/new-request', label: 'ยื่นคำขอใหม่', icon: PlusCircle      },
]

function handleLogout() {
  auth.logout()
  router.push({ name: 'login' })
}
</script>
