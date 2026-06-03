<template>
  <div class="auth-wrapper">
    <div class="brand">
      <div class="brand-icon">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="16" y1="13" x2="8" y2="13"/>
          <line x1="16" y1="17" x2="8" y2="17"/>
          <polyline points="10 9 9 9 8 9"/>
        </svg>
      </div>
      <h1 class="brand-title">สร้างบัญชีใหม่</h1>
      <p class="brand-sub">สมัครสมาชิกในฐานะผู้ใช้ทั่วไป</p>
    </div>

    <div class="card">
      <form @submit.prevent="handleSubmit">
        <div class="field">
          <label>ชื่อ-นามสกุล <span class="required">*</span></label>
          <input
            v-model="form.name"
            type="text"
            placeholder="กรอกชื่อ-นามสกุล"
            required
            autocomplete="name"
          />
        </div>

        <div class="field">
          <label>อีเมล <span class="required">*</span></label>
          <input
            v-model="form.email"
            type="email"
            placeholder="you@example.com"
            required
            autocomplete="email"
          />
        </div>

        <div class="field">
          <label>รหัสผ่าน <span class="required">*</span></label>
          <input
            v-model="form.password"
            type="password"
            placeholder="อย่างน้อย 6 ตัวอักษร"
            required
            minlength="6"
            autocomplete="new-password"
          />
        </div>

        <div class="field">
          <label>ยืนยันรหัสผ่าน <span class="required">*</span></label>
          <input
            v-model="form.password_confirmation"
            type="password"
            placeholder="กรอกรหัสผ่านอีกครั้ง"
            required
            autocomplete="new-password"
          />
        </div>

        <p v-if="error" class="error-msg">{{ error }}</p>

        <button type="submit" :disabled="loading" class="btn-primary">
          {{ loading ? 'กำลังสมัครสมาชิก...' : 'สมัครสมาชิก' }}
        </button>
      </form>

      <p class="auth-link">
        มีบัญชีอยู่แล้ว?
        <RouterLink to="/auth/login">เข้าสู่ระบบที่นี่</RouterLink>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()

const form = ref({ name: '', email: '', password: '', password_confirmation: '' })
const loading = ref(false)
const error = ref('')

async function handleSubmit() {
  if (form.value.password !== form.value.password_confirmation) {
    error.value = 'รหัสผ่านไม่ตรงกัน'
    return
  }
  loading.value = true
  error.value = ''
  try {
    await auth.register(form.value)
    router.push({ name: 'home' })
  } catch (e) {
    error.value = e.message || 'สมัครสมาชิกไม่สำเร็จ กรุณาลองอีกครั้ง'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.auth-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  padding: 2rem 1rem;
}

.brand {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 1.5rem;
}

.brand-icon {
  width: 64px;
  height: 64px;
  background: #2d7a58;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
}

.brand-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #111827;
  margin: 0 0 0.25rem;
}

.brand-sub {
  font-size: 0.95rem;
  color: #6b7280;
  margin: 0;
}

.card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
  padding: 2rem;
  width: 100%;
  max-width: 440px;
}

.field {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
  margin-bottom: 1.25rem;
}

.field label {
  font-size: 0.9rem;
  font-weight: 500;
  color: #374151;
}

.required {
  color: #ef4444;
}

.field input {
  padding: 0.65rem 0.875rem;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  font-size: 0.95rem;
  color: #111827;
  outline: none;
  transition: border-color 0.2s;
}

.field input:focus {
  border-color: #2d7a58;
  box-shadow: 0 0 0 3px rgba(45, 122, 88, 0.1);
}

.field input::placeholder {
  color: #9ca3af;
}

.error-msg {
  color: #dc2626;
  font-size: 0.85rem;
  margin: -0.5rem 0 1rem;
}

.btn-primary {
  width: 100%;
  padding: 0.75rem;
  background: #2d7a58;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
  margin-bottom: 1.25rem;
}

.btn-primary:hover:not(:disabled) {
  background: #256647;
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.auth-link {
  text-align: center;
  font-size: 0.875rem;
  color: #6b7280;
  margin: 0;
}

.auth-link a {
  color: #2d7a58;
  font-weight: 600;
  text-decoration: none;
}

.auth-link a:hover {
  text-decoration: underline;
}
</style>
