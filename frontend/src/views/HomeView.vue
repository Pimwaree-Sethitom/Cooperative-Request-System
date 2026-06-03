<template>
  <div>
    <div class="px-8 h-20 flex flex-col justify-center bg-white border-b border-gray-200">
      <h1 class="text-xl font-bold text-gray-900">แดชบอร์ด</h1>
      <p class="text-sm text-gray-500 mt-0.5">ยินดีต้อนรับกลับ, {{ auth.user?.name ?? 'ผู้ใช้งาน' }}</p>
    </div>
    <div class="p-8 flex flex-col gap-6">

    <!-- Stats -->
    <div class="stats-row">
      <StatsCard label="คำขอทั้งหมด" :value="stats.total">
        <template #icon>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
          </svg>
        </template>
      </StatsCard>

      <StatsCard label="รอดำเนินการ" :value="stats.pending" variant="pending">
        <template #icon>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
        </template>
      </StatsCard>

      <StatsCard label="อนุมัติแล้ว" :value="stats.approved" variant="approved">
        <template #icon>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
          </svg>
        </template>
      </StatsCard>

      <StatsCard label="ถูกปฏิเสธ" :value="stats.rejected" variant="rejected">
        <template #icon>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/>
            <line x1="9" y1="9" x2="15" y2="15"/>
          </svg>
        </template>
      </StatsCard>
    </div>

    <div class="content-row">
      <!-- CTA -->
      <div class="card cta-card">
        <div class="cta-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2d7a58" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="16"/>
            <line x1="8" y1="12" x2="16" y2="12"/>
          </svg>
        </div>
        <h2>ยื่นคำขอจดทะเบียนสหกรณ์ใหม่</h2>
        <p>เริ่มต้นกระบวนการจดทะเบียนสหกรณ์ของคุณ เจ้าหน้าที่จะพิจารณาคำขอภายใน 5-7 วันทำการ</p>
        <RouterLink to="/new-request" class="btn-primary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="16"/>
            <line x1="8" y1="12" x2="16" y2="12"/>
          </svg>
          สร้างคำขอใหม่
        </RouterLink>
      </div>

      <!-- Quick Links -->
      <div class="card quick-links">
        <h3>ลิงก์ด่วน</h3>
        <RouterLink to="/my-requests" class="quick-item">
          <div class="quick-item-icon quick-item-icon--blue">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
            </svg>
          </div>
          <div>
            <p class="quick-item-title">คำขอของฉัน</p>
            <p class="quick-item-sub">ดูคำขอที่ยื่นไว้ทั้งหมด</p>
          </div>
        </RouterLink>
        <RouterLink to="/new-request" class="quick-item">
          <div class="quick-item-icon quick-item-icon--green">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2d7a58" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="16"/>
              <line x1="8" y1="12" x2="16" y2="12"/>
            </svg>
          </div>
          <div>
            <p class="quick-item-title">คำขอใหม่</p>
            <p class="quick-item-sub">จดทะเบียนสหกรณ์</p>
          </div>
        </RouterLink>
      </div>
    </div>

    <!-- Recent Requests -->
    <div class="card">
      <div class="recent-header">
        <div>
          <h3>คำขอล่าสุด</h3>
          <p class="recent-sub">คำขอจดทะเบียนสหกรณ์ล่าสุดของคุณ</p>
        </div>
        <RouterLink to="/my-requests" class="link-all">ดูทั้งหมด</RouterLink>
      </div>
      <div class="recent-list">
        <div v-for="req in recentRequests" :key="req.id" class="recent-item">
          <div class="recent-item-info">
            <p class="recent-name">{{ req.name }}</p>
            <p class="recent-meta">{{ req.province }} · {{ req.members }} สมาชิก</p>
          </div>
          <div class="recent-item-right">
            <StatusBadge :status="req.status" />
            <span class="recent-date">{{ req.date }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'
import StatsCard from '@/components/StatsCard.vue'
import StatusBadge from '@/components/StatusBadge.vue'

const auth = useAuthStore()

const recentRequests = [
  { id: 1, name: 'สมาคมทอผ้าไหม',              province: 'ขอนแก่น',  members: 67, status: 'approved', date: '20 ม.ค. 2567' },
  { id: 2, name: 'สหกรณ์หัตถกรรมดอยสูง',        province: 'แม่ฮ่องสอน', members: 28, status: 'rejected', date: '12 ม.ค. 2567' },
  { id: 3, name: 'สหกรณ์เกษตรกรหุบเขาเขียว',   province: 'เชียงใหม่',  members: 45, status: 'approved', date: '10 ม.ค. 2567' },
]

const stats = computed(() => ({
  total:    recentRequests.length,
  pending:  recentRequests.filter(r => r.status === 'pending').length,
  approved: recentRequests.filter(r => r.status === 'approved').length,
  rejected: recentRequests.filter(r => r.status === 'rejected').length,
}))
</script>

<style scoped>
.page {
  padding: 2rem;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}
.page-header h1 {
  font-size: 1.4rem;
  font-weight: 700;
  color: #111827;
  margin: 0 0 0.2rem;
}
.page-header p {
  font-size: 0.875rem;
  color: #6b7280;
  margin: 0;
}

/* Stats */
.stats-row {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

/* Content row */
.content-row {
  display: grid;
  grid-template-columns: 1fr 280px;
  gap: 1.5rem;
}

.card {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  padding: 1.5rem;
}

/* CTA */
.cta-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 0.75rem;
}
.cta-icon {
  width: 56px;
  height: 56px;
  background: #f0fdf4;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.cta-card h2 {
  font-size: 1rem;
  font-weight: 700;
  color: #111827;
  margin: 0;
}
.cta-card p {
  font-size: 0.85rem;
  color: #6b7280;
  margin: 0;
  max-width: 380px;
}
.btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.6rem 1.25rem;
  background: #2d7a58;
  color: #fff;
  border-radius: 8px;
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 600;
  transition: background 0.2s;
  margin-top: 0.25rem;
}
.btn-primary:hover { background: #256647; }

/* Quick Links */
.quick-links h3 {
  font-size: 0.9rem;
  font-weight: 700;
  color: #111827;
  margin: 0 0 1rem;
}
.quick-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem;
  border-radius: 8px;
  text-decoration: none;
  transition: background 0.15s;
  margin-bottom: 0.5rem;
}
.quick-item:hover { background: #f9fafb; }
.quick-item-icon {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.quick-item-icon--blue  { background: #eff6ff; }
.quick-item-icon--green { background: #f0fdf4; }
.quick-item-title {
  font-size: 0.875rem;
  font-weight: 600;
  color: #111827;
  margin: 0;
}
.quick-item-sub {
  font-size: 0.75rem;
  color: #9ca3af;
  margin: 0;
}

/* Recent */
.recent-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1rem;
}
.recent-header h3 {
  font-size: 0.95rem;
  font-weight: 700;
  color: #111827;
  margin: 0 0 0.2rem;
}
.recent-sub {
  font-size: 0.8rem;
  color: #9ca3af;
  margin: 0;
}
.link-all {
  font-size: 0.85rem;
  color: #2d7a58;
  text-decoration: none;
  font-weight: 500;
}
.link-all:hover { text-decoration: underline; }

.recent-list { display: flex; flex-direction: column; }
.recent-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.85rem 0;
  border-bottom: 1px solid #f3f4f6;
}
.recent-item:last-child { border-bottom: none; }
.recent-name {
  font-size: 0.9rem;
  font-weight: 600;
  color: #111827;
  margin: 0 0 0.2rem;
}
.recent-meta {
  font-size: 0.78rem;
  color: #9ca3af;
  margin: 0;
}
.recent-item-right {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}
.recent-date {
  font-size: 0.78rem;
  color: #9ca3af;
}
</style>
