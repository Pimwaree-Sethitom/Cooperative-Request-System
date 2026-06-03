<template>
  <div>
    <div class="px-8 h-20 flex flex-col justify-center bg-white border-b border-gray-200">
      <h1 class="text-xl font-bold text-gray-900">ยื่นคำขอใหม่</h1>
      <p class="text-sm text-gray-500 mt-0.5">กรอกรายละเอียดด้านล่าง โดยต้องมีสมาชิกก่อตั้งอย่างน้อย 10 คน</p>
    </div>
    <div class="p-8 max-w-3xl">

    <RouterLink to="/" class="inline-flex items-center gap-1 text-sm text-primary-600 hover:underline mb-6">
      <ChevronLeft class="w-4 h-4" />
      กลับหน้าแดชบอร์ด
    </RouterLink>

    <form @submit.prevent="handleSubmit" class="space-y-5">
      <!-- ข้อมูลสหกรณ์ -->
      <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <h2 class="text-sm font-bold text-gray-800 mb-4">ข้อมูลสหกรณ์</h2>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">
            ชื่อสหกรณ์ <span class="text-red-500">*</span>
          </label>
          <input
            v-model="form.name"
            type="text"
            required
            placeholder="เช่น สหกรณ์การเกษตรกันไวโดดี"
            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg outline-none focus:border-primary-600 focus:ring-2 focus:ring-primary-600/10 transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            รายละเอียด <span class="text-xs text-gray-400">(ไม่บังคับ)</span>
          </label>
          <textarea
            v-model="form.description"
            rows="3"
            placeholder="อธิบายวัตถุประสงค์ของสหกรณ์โดยย่อ..."
            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg outline-none focus:border-primary-600 focus:ring-2 focus:ring-primary-600/10 transition resize-none"
          />
        </div>
      </div>

      <!-- สมาชิกผู้ก่อตั้ง -->
      <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-1">
          <h2 class="text-sm font-bold text-gray-800">สมาชิกผู้ก่อตั้ง</h2>
          <button
            type="button"
            @click="addMember"
            class="inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-700 transition"
          >
            <Plus class="w-4 h-4" />
            เพิ่มสมาชิก
          </button>
        </div>
        <p class="text-xs mb-4" :class="members.length >= 10 ? 'text-primary-600' : 'text-red-500'">
          {{ members.length }} คน
          <span class="text-gray-400">(ต้องมีอย่างน้อย 10 คน)</span>
        </p>

        <div class="space-y-3">
          <div
            v-for="(m, i) in members"
            :key="m.id"
            class="flex items-center gap-3"
          >
            <span class="w-6 text-xs text-gray-400 text-right shrink-0 font-medium">{{ i + 1 }}</span>
            <input
              v-model="m.fullName"
              type="text"
              required
              placeholder="ชื่อ-นามสกุล *"
              class="flex-1 min-w-0 px-3 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:border-primary-600 focus:ring-2 focus:ring-primary-600/10 transition"
            />
            <input
              v-model="m.nationalId"
              type="text"
              placeholder="เลขบัตรประชาชน"
              maxlength="13"
              class="w-40 px-3 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:border-primary-600 focus:ring-2 focus:ring-primary-600/10 transition"
            />
            <input
              v-model="m.phone"
              type="text"
              placeholder="เบอร์โทรศัพท์"
              class="w-36 px-3 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:border-primary-600 focus:ring-2 focus:ring-primary-600/10 transition"
            />
            <button
              type="button"
              @click="removeMember(i)"
              :disabled="members.length <= 10"
              class="p-1.5 rounded-lg text-gray-300 hover:text-red-400 hover:bg-red-50 transition disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-transparent disabled:hover:text-gray-300 shrink-0"
            >
              <X class="w-4 h-4" />
            </button>
          </div>
        </div>

        <button
          type="button"
          @click="addMember"
          class="mt-4 w-full py-2.5 border border-dashed border-gray-300 rounded-lg text-sm text-gray-400 hover:border-primary-400 hover:text-primary-600 transition flex items-center justify-center gap-1"
        >
          <Plus class="w-4 h-4" />
          เพิ่มสมาชิกอีกคน
        </button>
      </div>

      <p v-if="error" class="text-sm text-red-500">{{ error }}</p>

      <!-- Actions -->
      <div class="flex justify-end gap-3 pt-1">
        <RouterLink
          to="/"
          class="px-5 py-2 text-sm font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
        >
          ยกเลิก
        </RouterLink>
        <button
          type="submit"
          :disabled="loading || members.length < 10"
          class="px-5 py-2 text-sm font-semibold bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ loading ? 'กำลังส่งคำขอ...' : 'ส่งคำขอ' }}
        </button>
      </div>
    </form>
  </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { ChevronLeft, Plus, X } from '@lucide/vue'

const router = useRouter()

const form = ref({ name: '', description: '' })
const loading = ref(false)
const error = ref('')

let nextId = 11
const members = ref(
  Array.from({ length: 10 }, (_, i) => ({
    id: i + 1,
    fullName: '',
    nationalId: '',
    phone: '',
  }))
)

function addMember() {
  members.value.push({ id: nextId++, fullName: '', nationalId: '', phone: '' })
}

function removeMember(index) {
  if (members.value.length > 10) {
    members.value.splice(index, 1)
  }
}

async function handleSubmit() {
  if (members.value.length < 10) {
    error.value = 'ต้องมีสมาชิกผู้ก่อตั้งอย่างน้อย 10 คน'
    return
  }
  loading.value = true
  error.value = ''
  try {
    await new Promise(r => setTimeout(r, 800))
    router.push('/my-requests')
  } catch {
    error.value = 'เกิดข้อผิดพลาด กรุณาลองอีกครั้ง'
  } finally {
    loading.value = false
  }
}
</script>
