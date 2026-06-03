import api from './api'

export const authService = {
  login:    (credentials) => api.post('/login', credentials),
  register: (payload)     => api.post('/register', payload),
  logout:   ()            => api.post('/logout'),
}
