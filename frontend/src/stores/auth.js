import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

const MOCK_USERS = [
  { email: 'public@test.com', password: 'public123', name: 'Public User', role: 'public' },
  { email: 'staff@test.com',  password: 'staff123',  name: 'Staff User',  role: 'staff'  },
]

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('user')) || null)
  const token = ref(localStorage.getItem('token') || null)

  const isAuthenticated = computed(() => !!token.value)

  async function login(credentials) {
    const found = MOCK_USERS.find(
      u => u.email === credentials.email && u.password === credentials.password
    )
    if (!found) throw new Error('อีเมลหรือรหัสผ่านไม่ถูกต้อง')
    const mockToken = 'mock-token-' + Date.now()
    const mockUser  = { name: found.name, email: found.email, role: found.role }
    token.value = mockToken
    user.value  = mockUser
    localStorage.setItem('token', mockToken)
    localStorage.setItem('user', JSON.stringify(mockUser))
  }

  async function register(payload) {
    const mockToken = 'mock-token-' + Date.now()
    const mockUser  = { name: payload.name, email: payload.email, role: 'public' }
    token.value = mockToken
    user.value  = mockUser
    localStorage.setItem('token', mockToken)
    localStorage.setItem('user', JSON.stringify(mockUser))
  }

  function logout() {
    token.value = null
    user.value = null
    localStorage.removeItem('token')
    localStorage.removeItem('user')
  }

  return { user, token, isAuthenticated, login, register, logout }
})
