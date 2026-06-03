<template>
  <div class="auth-bg">
    <RouterView />
  </div>
</template>

<style scoped>
.auth-bg {
  width: 100vw;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #c8e6d4 0%, #e0f2ea 40%, #f0faf5 100%);
}
</style>
