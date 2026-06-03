<template>
  <div>
    <AppPageHeader title="แดชบอร์ดเจ้าหน้าที่">
      ยินดีต้อนรับ, {{ auth.user?.name ?? 'เจ้าหน้าที่' }}
    </AppPageHeader>

    <div class="p-8 flex flex-col gap-6">

      <!-- Stats -->
      <div class="flex gap-4 flex-wrap">
        <StatsCard label="คำขอทั้งหมด" :value="stats.total">
          <template #icon>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
            </svg>
          </template>
        </StatsCard>

        <StatsCard label="รอตรวจสอบ" :value="stats.pending" variant="pending">
          <template #icon>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
          </template>
        </StatsCard>

        <StatsCard label="อนุมัติแล้ว" :value="stats.approved" variant="approved">
          <template #icon>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
              <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
          </template>
        </StatsCard>

        <StatsCard label="ถูกปฏิเสธ" :value="stats.rejected" variant="rejected">
          <template #icon>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <line x1="15" y1="9" x2="9" y2="15"/>
              <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
          </template>
        </StatsCard>
      </div>

      <div class="grid grid-cols-2 gap-6">
        <!-- Donut Chart -->
        <div class="bg-white border border-gray-200 rounded-xl p-6">
          <h3 class="text-sm font-bold text-gray-800 mb-5">การกระจายคำขอ</h3>
          <div class="flex flex-col items-center gap-6">
            <div class="relative w-44 h-44">
              <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                <circle cx="50" cy="50" r="38" fill="none" stroke="#e5e7eb" stroke-width="12"/>
                <circle
                  v-for="seg in chartSegments"
                  :key="seg.color"
                  cx="50" cy="50" r="38"
                  fill="none"
                  :stroke="seg.color"
                  stroke-width="12"
                  :stroke-dasharray="`${seg.dash} ${circumference}`"
                  :stroke-dashoffset="-seg.offset"
                  stroke-linecap="butt"
                />
              </svg>
              <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-2xl font-bold text-gray-900">{{ stats.total }}</span>
                <span class="text-xs text-gray-400">ทั้งหมด</span>
              </div>
            </div>
            <div class="flex items-center gap-5">
              <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
                <span class="text-xs text-gray-500">รอดำเนินการ</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                <span class="text-xs text-gray-500">อนุมัติแล้ว</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                <span class="text-xs text-gray-500">ถูกปฏิเสธ</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Requests -->
        <div class="bg-white border border-gray-200 rounded-xl p-6">
          <div class="flex justify-between items-start mb-1">
            <h3 class="text-sm font-bold text-gray-800">คำขอที่รอตรวจสอบ</h3>
            <RouterLink to="/staff/review" class="text-sm text-primary-600 font-medium hover:underline">ดูทั้งหมด</RouterLink>
          </div>
          <p class="text-xs text-gray-400 mb-4">รอการตรวจสอบจากคุณ</p>

          <div v-if="pendingRequests.length === 0" class="py-10 text-center">
            <p class="text-sm text-gray-400">ไม่มีคำขอที่รอตรวจสอบ</p>
          </div>
          <div v-else class="space-y-2">
            <div
              v-for="req in pendingRequests"
              :key="req.id"
              class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer"
            >
              <div>
                <p class="text-sm font-semibold text-gray-800">{{ req.name }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ req.submitter }} · {{ req.members }} สมาชิก</p>
              </div>
              <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-full font-medium">รอตรวจสอบ</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'
import AppPageHeader from '@/components/shared/AppPageHeader.vue'
import StatsCard from '@/components/ui/StatsCard.vue'

const auth = useAuthStore()

const requests = [
  { id: 1, name: 'สหกรณ์ A',        submitter: 'Public User', members: 10, status: 'rejected'  },
  { id: 2, name: 'สหกรณ์ทดสอบ',     submitter: 'Public User', members: 10, status: 'approved'  },
  { id: 3, name: 'test coop',        submitter: 'Public User', members: 10, status: 'approved'  },
  { id: 4, name: '????????????????', submitter: 'Public User', members: 10, status: 'rejected'  },
]

const stats = computed(() => ({
  total:    requests.length,
  pending:  requests.filter(r => r.status === 'pending').length,
  approved: requests.filter(r => r.status === 'approved').length,
  rejected: requests.filter(r => r.status === 'rejected').length,
}))

const pendingRequests = computed(() => requests.filter(r => r.status === 'pending'))

const circumference = 2 * Math.PI * 38

const chartSegments = computed(() => {
  const total = stats.value.total || 1
  const segments = [
    { value: stats.value.pending,  color: '#facc15' },
    { value: stats.value.approved, color: '#22c55e' },
    { value: stats.value.rejected, color: '#ef4444' },
  ]
  let offset = 0
  return segments.map(s => {
    const dash = (s.value / total) * circumference
    const seg  = { ...s, dash, offset }
    offset += dash
    return seg
  })
})
</script>
