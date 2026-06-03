<template>
  <form @submit.prevent="handleSubmit">
    <div class="field">
      <label>Name</label>
      <input v-model="form.name" type="text" required autocomplete="name" />
    </div>
    <div class="field">
      <label>Email</label>
      <input v-model="form.email" type="email" required autocomplete="email" />
    </div>
    <div class="field">
      <label>Password</label>
      <input v-model="form.password" type="password" required autocomplete="new-password" />
    </div>
    <div class="field">
      <label>Confirm Password</label>
      <input v-model="form.password_confirmation" type="password" required />
    </div>
    <p v-if="error" class="error">{{ error }}</p>
    <button type="submit" :disabled="loading">
      {{ loading ? 'Registering...' : 'Register' }}
    </button>
    <p class="link">
      Already have an account? <RouterLink to="/auth/login">Login</RouterLink>
    </p>
  </form>
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
  loading.value = true
  error.value = ''
  try {
    await auth.register(form.value)
    router.push({ name: 'home' })
  } catch (e) {
    error.value = e.message || 'Registration failed'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.field {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  margin-bottom: 1rem;
}
input {
  padding: 0.5rem 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 4px;
  font-size: 1rem;
}
button {
  width: 100%;
  padding: 0.6rem;
  background: #1a1a2e;
  color: #fff;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
}
button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
.error {
  color: #dc2626;
  font-size: 0.875rem;
  margin-bottom: 0.75rem;
}
.link {
  text-align: center;
  margin-top: 1rem;
  font-size: 0.875rem;
}
</style>
