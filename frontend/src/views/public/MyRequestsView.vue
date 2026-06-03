<template>
  <div>
    <AppPageHeader title="คำขอของฉัน" subtitle="คำขอจดทะเบียนสหกรณ์ทั้งหมดของคุณ" />
    <div class="p-8">
      <div v-if="isLoading" class="py-20 text-center text-sm text-gray-400">กำลังโหลด...</div>
      <div v-else-if="error" class="py-20 text-center text-sm text-red-500">{{ error }}</div>
      <template v-else>

    <!-- Filter tabs -->
    <div class="flex gap-1 mb-4 bg-gray-100 p-1 rounded-lg w-fit border border-gray-200">
      <button
        v-for="tab in tabs"
        :key="tab.value"
        @click="activeTab = tab.value"
        class="px-4 py-1.5 text-sm font-medium rounded-md transition-colors"
        :class="activeTab === tab.value
          ? 'bg-white text-gray-900 shadow-sm border border-gray-200'
          : 'text-gray-500 hover:text-gray-700'"
      >
        {{ tab.label }}
        <span class="ml-1 text-xs opacity-70">({{ tabCount(tab.value) }})</span>
      </button>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
      <!-- Empty state -->
      <div v-if="filtered.length === 0" class="py-20 text-center">
        <FileText class="w-10 h-10 text-gray-300 mx-auto mb-3" />
        <p class="text-sm text-gray-400 mb-4">ไม่พบคำขอ</p>
        <RouterLink
          to="/new-request"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors"
        >
          <PlusCircle class="w-4 h-4" />
          สร้างคำขอใหม่
        </RouterLink>
      </div>

      <!-- Table -->
      <div v-else>
        <div class="grid grid-cols-12 gap-4 px-5 py-3 border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase tracking-wider">
          <div class="col-span-4">ชื่อสหกรณ์</div>
          <div class="col-span-2 text-center">สมาชิก</div>
          <div class="col-span-2 text-center">สถานะ</div>
          <div class="col-span-2">วันที่ยื่น</div>
          <div class="col-span-2">วันที่ตรวจสอบ</div>
        </div>
        <div
          v-for="coop in filtered"
          :key="coop.id"
          class="grid grid-cols-12 gap-4 px-5 py-4 border-b border-gray-100 last:border-0 items-center hover:bg-gray-50 transition-colors cursor-pointer"
          @click="selected = coop"
        >
          <div class="col-span-4">
            <p class="text-sm font-semibold text-gray-800">{{ coop.name }}</p>
            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ coop.description || '—' }}</p>
          </div>
          <div class="col-span-2 text-center text-sm text-gray-600">{{ coop.members.length }}</div>
          <div class="col-span-2 flex justify-center">
            <span :class="statusClass(coop.status)" class="text-xs font-medium px-2.5 py-0.5 rounded-full">
              {{ statusLabel(coop.status) }}
            </span>
          </div>
          <div class="col-span-2 text-xs text-gray-500">{{ formatDate(coop.createdAt) }}</div>
          <div class="col-span-2 text-xs text-gray-500">{{ coop.reviewedAt ? formatDate(coop.reviewedAt) : '—' }}</div>
        </div>
      </div>
    </div>

    <!-- Detail modal -->
    <div
      v-if="selected"
      class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4"
      @click.self="selected = null"
    >
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[80vh] flex flex-col">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
          <div>
            <h2 class="text-base font-bold text-gray-900">{{ selected.name }}</h2>
            <span :class="statusClass(selected.status)" class="text-xs font-medium px-2 py-0.5 rounded-full mt-1 inline-block">
              {{ statusLabel(selected.status) }}
            </span>
          </div>
          <button @click="selected = null" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
            <X class="w-5 h-5" />
          </button>
        </div>
        <div class="overflow-y-auto flex-1 p-6 space-y-5">
          <div v-if="selected.description">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">รายละเอียด</p>
            <p class="text-sm text-gray-700">{{ selected.description }}</p>
          </div>
          <div v-if="selected.staffNote" class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
            <p class="text-xs font-semibold text-yellow-700 mb-1">บันทึกเจ้าหน้าที่</p>
            <p class="text-sm text-yellow-800">{{ selected.staffNote }}</p>
          </div>
          <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">สมาชิก ({{ selected.members.length }} คน)</p>
            <div class="space-y-1.5">
              <div
                v-for="(m, i) in selected.members.slice(0, 10)"
                :key="m.id"
                class="flex items-center gap-3 p-2.5 rounded-lg bg-gray-50"
              >
                <span class="w-6 h-6 rounded-full bg-primary-100 text-primary-600 text-xs font-bold flex items-center justify-center shrink-0">
                  {{ i + 1 }}
                </span>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-800">{{ m.fullName }}</p>
                  <p class="text-xs text-gray-400">{{ [m.nationalId, m.phone].filter(Boolean).join(' · ') || '—' }}</p>
                </div>
              </div>
              <p v-if="selected.members.length > 10" class="text-xs text-gray-400 text-center pt-1">
                + อีก {{ selected.members.length - 10 }} คน
              </p>
            </div>
          </div>
          <div class="text-xs text-gray-400 space-y-1 pt-2 border-t border-gray-100">
            <p>วันที่ยื่น: {{ formatDate(selected.createdAt) }}</p>
            <p v-if="selected.reviewedAt">วันที่ตรวจสอบ: {{ formatDate(selected.reviewedAt) }}</p>
            <p v-if="selected.reviewerName">ผู้ตรวจสอบ: {{ selected.reviewerName }}</p>
          </div>
        </div>
      </div>
    </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AppPageHeader from '@/components/shared/AppPageHeader.vue'
import { FileText, PlusCircle, X } from '@lucide/vue'
import { cooperativeService } from '@/services/cooperative.service'

const activeTab  = ref('all')
const selected   = ref(null)
const isLoading  = ref(false)
const error      = ref('')

const cooperatives = ref([])

function mapCooperative(c) {
  return {
    id:           c.id,
    name:         c.name,
    description:  c.description,
    status:       c.status,
    createdAt:    c.created_at,
    reviewedAt:   c.reviewed_at,
    staffNote:    c.staff_note,
    reviewerName: c.reviewer?.full_name ?? null,
    members:      (c.members ?? []).map(m => ({
      id:         m.id,
      fullName:   m.full_name,
      nationalId: m.national_id,
      phone:      m.phone,
    })),
  }
}

onMounted(async () => {
  isLoading.value = true
  try {
    const res = await cooperativeService.getMy()
    cooperatives.value = (res.data ?? []).map(mapCooperative)
  } catch {
    error.value = 'ไม่สามารถโหลดข้อมูลได้ กรุณาลองใหม่'
  } finally {
    isLoading.value = false
  }
})

const tabs = [
  { label: 'ทั้งหมด',     value: 'all'      },
  { label: 'รอดำเนินการ', value: 'pending'  },
  { label: 'อนุมัติแล้ว', value: 'approved' },
  { label: 'ถูกปฏิเสธ',   value: 'rejected' },
]

const filtered = computed(() =>
  activeTab.value === 'all'
    ? cooperatives.value
    : cooperatives.value.filter(c => c.status === activeTab.value)
)

function tabCount(value) {
  if (value === 'all') return cooperatives.value.length
  return cooperatives.value.filter(c => c.status === value).length
}

function statusClass(status) {
  if (status === 'approved') return 'bg-green-100 text-green-700'
  if (status === 'rejected') return 'bg-red-100 text-red-700'
  return 'bg-yellow-100 text-yellow-700'
}

function statusLabel(status) {
  if (status === 'approved') return 'อนุมัติแล้ว'
  if (status === 'rejected') return 'ถูกปฏิเสธ'
  return 'รอดำเนินการ'
}

function formatDate(dateStr) {
  if (!dateStr) return ''
  return new Date(dateStr).toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: 'numeric' })
}
</script>
