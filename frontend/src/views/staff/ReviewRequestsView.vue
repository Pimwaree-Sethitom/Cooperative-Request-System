<template>
  <div>
    <AppPageHeader title="ตรวจสอบคำขอ" subtitle="จัดการและตรวจสอบคำขอจดทะเบียนสหกรณ์" />

    <div class="p-8">
      <!-- Toolbar -->
      <div class="flex gap-3 mb-5">
        <div class="relative flex-1">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          <input
            v-model="search"
            type="text"
            placeholder="ค้นหาด้วยชื่อสหกรณ์หรือผู้ยื่นคำขอ..."
            class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg outline-none focus:border-primary-600 focus:ring-2 focus:ring-primary-600/10 transition"
          />
        </div>
        <select
          v-model="filterStatus"
          class="select-styled px-4 py-2 pr-9 text-sm font-medium text-gray-700 bg-white border-2 border-gray-200 rounded-xl outline-none cursor-pointer appearance-none hover:border-gray-300 focus:border-primary-600 transition-colors"
        >
          <option value="">สถานะทั้งหมด</option>
          <option value="pending">รอตรวจสอบ</option>
          <option value="approved">อนุมัติแล้ว</option>
          <option value="rejected">ถูกปฏิเสธ</option>
        </select>
      </div>

      <!-- Table -->
      <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b border-gray-100">
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider w-[35%]">สหกรณ์</th>
              <th class="text-center px-4 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider w-[12%]">สมาชิก</th>
              <th class="text-center px-4 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider w-[18%]">สถานะ</th>
              <th class="text-left px-4 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider w-[20%]">วันที่</th>
              <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider w-[15%]">การดำเนินการ</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="req in paginated"
              :key="req.id"
              class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors"
            >
              <td class="px-5 py-4">
                <p class="font-semibold text-gray-800">{{ req.name }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ req.submitter }}</p>
              </td>
              <td class="px-4 py-4 text-center text-gray-600">{{ req.members }}</td>
              <td class="px-4 py-4">
                <div class="flex justify-center">
                  <StatusBadge :status="req.status" />
                </div>
              </td>
              <td class="px-4 py-4 text-xs text-gray-500">{{ formatDate(req.createdAt) }}</td>
              <td class="px-5 py-4 text-right">
                <div class="flex items-center justify-end gap-3">
                  <button
                    @click="selected = req; reviewMode = false"
                    class="text-sm text-gray-500 hover:text-gray-800 transition-colors"
                  >ดู</button>
                  <button
                    v-if="req.status === 'pending'"
                    @click="selected = req; reviewMode = true"
                    class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors"
                  >ตรวจสอบ</button>
                </div>
              </td>
            </tr>
            <tr v-if="paginated.length === 0">
              <td colspan="5" class="py-16 text-center text-sm text-gray-400">ไม่พบข้อมูล</td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div v-if="filtered.length > 0" class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
          <p class="text-xs text-gray-500">
            แสดง {{ (page - 1) * perPage + 1 }}–{{ Math.min(page * perPage, filtered.length) }} จาก {{ filtered.length }} รายการ
          </p>
          <div class="flex items-center gap-1">
            <button
              @click="page--"
              :disabled="page === 1"
              class="px-3 py-1 text-xs rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
            >ก่อนหน้า</button>
            <button
              v-for="p in totalPages"
              :key="p"
              @click="page = p"
              class="w-8 h-7 text-xs rounded-lg border transition-colors"
              :class="page === p ? 'bg-primary-600 text-white border-primary-600' : 'border-gray-200 text-gray-500 hover:bg-gray-50'"
            >{{ p }}</button>
            <button
              @click="page++"
              :disabled="page === totalPages"
              class="px-3 py-1 text-xs rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
            >ถัดไป</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div
      v-if="selected"
      class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4"
      @click.self="selected = null"
    >
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[85vh] flex flex-col">
        <!-- Modal Header -->
        <div class="flex items-start justify-between p-6 border-b border-gray-100">
          <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">รายละเอียดคำขอ</p>
            <h2 class="text-base font-bold text-gray-900">{{ selected.name }}</h2>
            <StatusBadge :status="selected.status" class="mt-1" />
          </div>
          <button @click="selected = null" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="overflow-y-auto flex-1 p-6 space-y-5">
          <!-- Staff Note -->
          <div v-if="selected.staffNote" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-xs font-semibold text-yellow-700 mb-1">บันทึกเจ้าหน้าที่</p>
            <p class="text-sm text-yellow-800">{{ selected.staffNote }}</p>
          </div>

          <!-- Members -->
          <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">สมาชิก ({{ selected.memberList.length }} คน)</p>
            <div class="space-y-2">
              <div
                v-for="(m, i) in selected.memberList"
                :key="i"
                class="flex items-center gap-3 p-2.5 rounded-lg bg-gray-50"
              >
                <span class="w-7 h-7 rounded-full bg-primary-600 text-white text-xs font-bold flex items-center justify-center shrink-0">
                  {{ i + 1 }}
                </span>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-800">{{ m.fullName }}</p>
                  <p v-if="m.nationalId || m.phone" class="text-xs text-gray-400">
                    {{ [m.nationalId, m.phone].filter(Boolean).join(' · ') }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Timestamps -->
          <div class="text-xs text-gray-400 space-y-1 pt-2 border-t border-gray-100">
            <p>ผู้ยื่นคำขอ: {{ selected.submitter }}</p>
            <p>วันที่ยื่น: {{ formatDate(selected.createdAt) }}</p>
          </div>
        </div>

        <!-- Modal Actions (review mode only) -->
        <div v-if="reviewMode && selected.status === 'pending'" class="p-5 border-t border-gray-100 flex gap-3 justify-end">
          <button
            @click="updateStatus('rejected')"
            class="px-5 py-2 text-sm font-semibold text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors"
          >ปฏิเสธ</button>
          <button
            @click="updateStatus('approved')"
            class="px-5 py-2 text-sm font-semibold bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"
          >อนุมัติ</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import AppPageHeader from '@/components/shared/AppPageHeader.vue'
import StatusBadge from '@/components/ui/StatusBadge.vue'

const search       = ref('')
const filterStatus = ref('')
const selected     = ref(null)
const reviewMode   = ref(false)
const page         = ref(1)
const perPage      = 10

const requests = ref([
  {
    id: 1, name: 'สหกรณ์ A', submitter: 'Public User', members: 10, status: 'rejected',
    createdAt: '2026-05-29T00:00:00Z', staffNote: 'ข้อมูลไม่ถูกต้อง',
    memberList: [
      { fullName: 'ก', nationalId: '', phone: '' },
      { fullName: 'ม', nationalId: '', phone: '' },
      { fullName: 'ท', nationalId: '', phone: '' },
      { fullName: 'ส', nationalId: '', phone: '' },
      { fullName: 'ย', nationalId: '', phone: '' },
      { fullName: 'ว', nationalId: '', phone: '' },
      { fullName: 'ป', nationalId: '', phone: '' },
      { fullName: 'ช', nationalId: '', phone: '' },
      { fullName: 'น', nationalId: '', phone: '' },
      { fullName: 'อ', nationalId: '', phone: '' },
    ],
  },
  {
    id: 2, name: 'สหกรณ์ทดสอบ', submitter: 'Public User', members: 10, status: 'approved',
    createdAt: '2026-05-29T00:00:00Z', staffNote: null,
    memberList: Array.from({ length: 10 }, (_, i) => ({ fullName: `สมาชิก ${i + 1}`, nationalId: '', phone: '' })),
  },
  {
    id: 3, name: 'test coop', submitter: 'Public User', members: 10, status: 'approved',
    createdAt: '2026-05-29T00:00:00Z', staffNote: null,
    memberList: Array.from({ length: 10 }, (_, i) => ({ fullName: `Member ${i + 1}`, nationalId: '', phone: '' })),
  },
  {
    id: 4, name: '????????????????', submitter: 'Public User', members: 10, status: 'rejected',
    createdAt: '2026-05-29T00:00:00Z', staffNote: 'ชื่อสหกรณ์ไม่ถูกต้อง',
    memberList: Array.from({ length: 10 }, (_, i) => ({ fullName: `สมาชิก ${i + 1}`, nationalId: '', phone: '' })),
  },
])

const filtered = computed(() =>
  requests.value.filter(r => {
    const matchSearch = r.name.includes(search.value) || r.submitter.includes(search.value)
    const matchStatus = filterStatus.value === '' || r.status === filterStatus.value
    return matchSearch && matchStatus
  })
)

const totalPages = computed(() => Math.ceil(filtered.value.length / perPage))
const paginated  = computed(() => filtered.value.slice((page.value - 1) * perPage, page.value * perPage))

function formatDate(dateStr) {
  return new Date(dateStr).toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: 'numeric' })
}

function updateStatus(status) {
  const req = requests.value.find(r => r.id === selected.value.id)
  if (req) req.status = status
  selected.value = null
}
</script>

<style scoped>
.select-styled {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 0.65rem center;
}
</style>
