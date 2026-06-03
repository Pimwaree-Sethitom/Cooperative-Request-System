<template>
  <div>
    <h2>Welcome, {{ auth.user?.name }}</h2>
    <p>Cooperative Request System Dashboard</p>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
</script>
