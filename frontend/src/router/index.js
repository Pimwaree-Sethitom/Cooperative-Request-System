import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes = [
  // Public routes
  {
    path: '/',
    component: () => import('@/layouts/DefaultLayout.vue'),
    meta: { requiresAuth: true, role: 'public' },
    children: [
      { path: '',            name: 'home',        component: () => import('@/views/public/HomeView.vue')       },
      { path: 'my-requests', name: 'my-requests', component: () => import('@/views/public/MyRequestsView.vue') },
      { path: 'new-request', name: 'new-request', component: () => import('@/views/public/NewRequestView.vue') },
    ],
  },

  // Staff routes
  {
    path: '/staff',
    component: () => import('@/layouts/StaffLayout.vue'),
    meta: { requiresAuth: true, role: 'staff' },
    children: [
      { path: '',       name: 'staff-home',   component: () => import('@/views/staff/StaffHomeView.vue')      },
      { path: 'review', name: 'staff-review', component: () => import('@/views/staff/ReviewRequestsView.vue') },
    ],
  },

  // Auth routes
  {
    path: '/auth',
    component: () => import('@/layouts/AuthLayout.vue'),
    children: [
      { path: 'login',    name: 'login',    component: () => import('@/views/auth/LoginView.vue')    },
      { path: 'register', name: 'register', component: () => import('@/views/auth/RegisterView.vue') },
    ],
  },

  { path: '/:pathMatch(.*)*', name: 'not-found', component: () => import('@/views/NotFoundView.vue') },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach((to) => {
  const auth = useAuthStore()

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return { name: 'login' }
  }

  if (auth.isAuthenticated) {
    const role = auth.user?.role

    // redirect ถ้าเข้า route ของ role อื่น
    if (to.meta.role && to.meta.role !== role) {
      return role === 'staff' ? { name: 'staff-home' } : { name: 'home' }
    }

    // redirect จาก login ไปหน้าของตัวเอง
    if (to.name === 'login' || to.name === 'register') {
      return role === 'staff' ? { name: 'staff-home' } : { name: 'home' }
    }
  }
})

export default router
