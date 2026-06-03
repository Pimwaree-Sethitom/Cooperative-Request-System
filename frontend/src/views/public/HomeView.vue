<template>
  <div>
    <AppPageHeader title="แดชบอร์ด">
      ยินดีต้อนรับกลับ, {{ auth.user?.name ?? 'ผู้ใช้งาน' }}
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

        <StatsCard label="รอดำเนินการ" :value="stats.pending" variant="pending">
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

      <div class="grid grid-cols-3 gap-6">
        <!-- CTA -->
        <div class="col-span-2 bg-white border border-gray-200 rounded-xl p-6 flex flex-col items-center text-center gap-3">
          <div class="w-14 h-14 bg-primary-50 rounded-full flex items-center justify-center">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2d7a58" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="16"/>
              <line x1="8" y1="12" x2="16" y2="12"/>
            </svg>
          </div>
          <h2 class="text-base font-bold text-gray-900">ยื่นคำขอจดทะเบียนสหกรณ์ใหม่</h2>
          <p class="text-sm text-gray-500 max-w-sm">เริ่มต้นกระบวนการจดทะเบียนสหกรณ์ของคุณ เจ้าหน้าที่จะพิจารณาคำขอภายใน 5-7 วันทำการ</p>
          <RouterLink to="/new-request" class="inline-flex items-center gap-2 px-5 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>
            </svg>
            สร้างคำขอใหม่
          </RouterLink>
        </div>

        <!-- Quick Links -->
        <div class="bg-white border border-gray-200 rounded-xl p-5">
          <h3 class="text-sm font-bold text-gray-800 mb-3">ลิงก์ด่วน</h3>
          <RouterLink to="/my-requests" class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-gray-50 transition-colors mb-1">
            <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
              </svg>
            </div>
            <div>
              <p class="text-sm font-semibold text-gray-800">คำขอของฉัน</p>
              <p class="text-xs text-gray-400">ดูคำขอที่ยื่นไว้ทั้งหมด</p>
            </div>
          </RouterLink>
          <RouterLink to="/new-request" class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-gray-50 transition-colors">
            <div class="w-9 h-9 bg-primary-50 rounded-lg flex items-center justify-center flex-shrink-0">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2d7a58" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>
              </svg>
            </div>
            <div>
              <p class="text-sm font-semibold text-gray-800">คำขอใหม่</p>
              <p class="text-xs text-gray-400">จดทะเบียนสหกรณ์</p>
            </div>
          </RouterLink>
        </div>
      </div>

      <!-- Recent Requests -->
      <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex justify-between items-start mb-4">
          <div>
            <h3 class="text-sm font-bold text-gray-900">คำขอล่าสุด</h3>
            <p class="text-xs text-gray-400 mt-0.5">คำขอจดทะเบียนสหกรณ์ล่าสุดของคุณ</p>
          </div>
          <RouterLink to="/my-requests" class="text-sm text-primary-600 font-medium hover:underline">ดูทั้งหมด</RouterLink>
        </div>
        <div>
          <div v-for="req in recentRequests" :key="req.id" class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
            <div>
              <p class="text-sm font-semibold text-gray-800">{{ req.name }}</p>
              <p class="text-xs text-gray-400 mt-0.5">{{ req.province }} · {{ req.members }} สมาชิก</p>
            </div>
            <div class="flex items-center gap-3">
              <StatusBadge :status="req.status" />
              <span class="text-xs text-gray-400">{{ req.date }}</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import AppPageHeader from '@/components/shared/AppPageHeader.vue'
import StatsCard from '@/components/ui/StatsCard.vue'
import StatusBadge from '@/components/ui/StatusBadge.vue'
import { cooperativeService } from '@/services/cooperative.service'

const auth = useAuthStore()

const requests = ref([])

onMounted(async () => {
  try {
    const res = await cooperativeService.getMy()
    requests.value = res.data ?? []
  } catch {}
})

const recentRequests = computed(() =>
  requests.value.slice(0, 3).map(r => ({
    id:     r.id,
    name:   r.name,
    members: r.initial_member_count,
    status: r.status,
    date:   new Date(r.created_at).toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: 'numeric' }),
  }))
)

const stats = computed(() => ({
  total:    requests.value.length,
  pending:  requests.value.filter(r => r.status === 'pending').length,
  approved: requests.value.filter(r => r.status === 'approved').length,
  rejected: requests.value.filter(r => r.status === 'rejected').length,
}))
</script>
