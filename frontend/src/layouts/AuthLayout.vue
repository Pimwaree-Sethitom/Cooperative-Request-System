<template>
  <div class="layout-auth">
    <div class="auth-card">
      <h1 class="auth-title">Cooperative Request System</h1>
      <RouterView />
    </div>
  </div>
</template>

<style scoped>
.layout-auth {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f0f2f5;
}
.auth-card {
  background: #fff;
  padding: 2.5rem 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 16px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}
.auth-title {
  text-align: center;
  font-size: 1.2rem;
  margin-bottom: 1.5rem;
  color: #1a1a2e;
}
</style>
