<template>
  <div class="layout-default">
    <header class="navbar">
      <span class="brand">Cooperative System</span>
      <nav>
        <RouterLink to="/">Home</RouterLink>
        <button @click="handleLogout">Logout</button>
      </nav>
    </header>
    <main class="content">
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()

function handleLogout() {
  auth.logout()
  router.push({ name: 'login' })
}
</script>

<style scoped>
.layout-default {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
.navbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 1.5rem;
  height: 56px;
  background: #1a1a2e;
  color: #fff;
}
.brand {
  font-weight: 700;
  font-size: 1.1rem;
}
nav {
  display: flex;
  align-items: center;
  gap: 1rem;
}
nav a {
  color: #fff;
  text-decoration: none;
}
nav button {
  background: none;
  border: 1px solid #fff;
  color: #fff;
  padding: 0.25rem 0.75rem;
  border-radius: 4px;
  cursor: pointer;
}
.content {
  flex: 1;
  padding: 2rem 1.5rem;
}
</style>
