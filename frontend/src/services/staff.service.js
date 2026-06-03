import api from './api'

export const staffService = {
  getAll:  (status = null) => api.get('/staff/cooperatives', { params: status ? { status } : {} }),
  review:  (id, payload)   => api.put(`/staff/cooperatives/${id}/review`, payload),
}
