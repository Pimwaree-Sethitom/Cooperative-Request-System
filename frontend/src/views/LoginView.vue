<template>
  <form @submit.prevent="handleSubmit">
    <div class="field">
      <label>Email</label>
      <input v-model="form.email" type="email" required autocomplete="email" />
    </div>
    <div class="field">
      <label>Password</label>
      <input v-model="form.password" type="password" required autocomplete="current-password" />
    </div>
    <p v-if="error" class="error">{{ error }}</p>
    <button type="submit" :disabled="loading">
      {{ loading ? 'Logging in...' : 'Login' }}
    </button>
    <p class="link">
      Don't have an account? <RouterLink to="/auth/register">Register</RouterLink>
    </p>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()

const form = ref({ email: '', password: '' })
const loading = ref(false)
const error = ref('')

async function handleSubmit() {
  loading.value = true
  error.value = ''
  try {
    await auth.login(form.value)
    router.push({ name: 'home' })
  } catch (e) {
    error.value = e.message || 'Login failed'
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
