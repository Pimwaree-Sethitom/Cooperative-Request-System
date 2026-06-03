import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { authService } from '@/services/auth.service'

export const useAuthStore = defineStore('auth', () => {
  const user  = ref(JSON.parse(localStorage.getItem('user')) || null)
  const token = ref(localStorage.getItem('token') || null)

  const isAuthenticated = computed(() => !!token.value)

  async function login(credentials) {
    const res = await authService.login(credentials)
    // backend returns: { status, data: { user, token } }
    const { user: apiUser, token: apiToken } = res.data
    const mapped = {
      name:  apiUser.full_name,
      email: apiUser.email,
      role:  apiUser.role.name,
    }
    token.value = apiToken
    user.value  = mapped
    localStorage.setItem('token', apiToken)
    localStorage.setItem('user', JSON.stringify(mapped))
  }

  async function register(payload) {
    const res = await authService.register(payload)
    const { user: apiUser, token: apiToken } = res.data
    const mapped = {
      name:  apiUser.full_name,
      email: apiUser.email,
      role:  apiUser.role.name,
    }
    token.value = apiToken
    user.value  = mapped
    localStorage.setItem('token', apiToken)
    localStorage.setItem('user', JSON.stringify(mapped))
  }

  function logout() {
    const savedToken = token.value
    token.value = null
    user.value  = null
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    if (savedToken) {
      const base = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
      fetch(`${base}/logout`, {
        method: 'POST',
        headers: { Authorization: `Bearer ${savedToken}` },
      }).catch(() => {})
    }
  }

  return { user, token, isAuthenticated, login, register, logout }
})
