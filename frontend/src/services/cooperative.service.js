import api from './api'

export const cooperativeService = {
  getMy:  ()        => api.get('/cooperatives'),
  create: (payload) => api.post('/cooperatives', payload),
}
