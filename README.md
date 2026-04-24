# Cooperative Request System

ระบบยื่นคำขอจัดตั้งสหกรณ์ (Backend API) พัฒนาด้วย Laravel 12 และ Docker

## 🌐 Live Demo
คุณสามารถทดสอบ API ที่รันอยู่บน Production ได้ที่นี่:
- **API URL:** `https://cooperative-request-system-production.up.railway.app/api`
- **สถานะ:** 🟢 Online (Railway)

## 🚀 วิธีการรันโปรเจกต์ (Getting Started)

### 1. เตรียมไฟล์สภาพแวดล้อม (.env)
คัดลอกไฟล์ `.env.example` ในโฟลเดอร์ `backend` ไปเป็น `.env` และตั้งค่าฐานข้อมูลให้ตรงกับ Docker:
```bash
cp backend/.env.example backend/.env
```
**ค่าที่ต้องตรวจสอบใน backend/.env:**
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=cooperative_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_password
```

### 2. รันระบบผ่าน Docker
ใช้คำสั่ง Docker Compose เพื่อสร้างและรัน Container (รันจากโฟลเดอร์นอกสุด):
```bash
docker compose up -d --build
```

### 3. ติดตั้ง Dependencies และตั้งค่าระบบ
รันคำสั่งเหล่านี้เพื่อเตรียมความพร้อมของแอปพลิเคชัน:
```bash
# ติดตั้ง PHP Libraries
docker compose exec app composer install

# สร้างกุญแจความปลอดภัย
docker compose exec app php artisan key:generate

# ติดตั้งระบบ API
docker compose exec app php artisan install:api
```

### 4. จัดการฐานข้อมูล (Migrate & Seed)
สร้างตารางทั้งหมดและใส่ข้อมูลเริ่มต้น (Roles และ User ทดสอบ):
```bash
docker compose exec app php artisan migrate:fresh --seed
```

---

## 🔑 ข้อมูลสำหรับทดสอบ (Test Accounts)

ระบบมาพร้อมกับ User เริ่มต้น 2 บทบาท ดังนี้:

| Role | Email | Password | หน้าที่ |
|------|-------|----------|-------|
| **เจ้าหน้าที่ (Staff)** | `staff@test.com` | `staff123` | ตรวจสอบ, อนุมัติ/ปฏิเสธคำขอ |
| **ประชาชน (Public)** | `public@test.com` | `public123` | ยื่นคำขอจัดตั้งสหกรณ์, ดูรายการของตัวเอง |

---

## 📡 การทดสอบ API (Postman)

โปรเจกต์นี้มีไฟล์ Postman Collection เตรียมไว้ให้ 2 รูปแบบตามความสะดวกในการใช้งาน:

### 1. ทดสอบผ่านระบบออนไลน์ (Live API) - *แนะนำสำหรับผู้ตรวจงาน*
หากต้องการทดสอบระบบที่รันอยู่บน Railway ทันทีโดยไม่ต้องตั้งค่าในเครื่อง:
- **ดาวน์โหลดไฟล์:** [คลิกที่นี่เพื่อเปิดหน้าเว็บ](https://cooperative-request-system-production.up.railway.app/) แล้วกดปุ่ม **Download & Import**
- **ไฟล์ต้นฉบับ:** `backend/public/postman/cooperative_api.json`
- **Base URL:** ตั้งค่าเป็น URL ของ Railway ให้โดยอัตโนมัติ

### 2. ทดสอบในเครื่องตัวเอง (Local Development)
หากทำการรัน Docker ในเครื่องตัวเอง:
- **ใช้ไฟล์:** `postman/cooperative_api.json`
- **Base URL:** `http://localhost:8000/api`

---

### 🛠️ ขั้นตอนการใช้งาน Postman
1. เปิดโปรแกรม Postman และกดปุ่ม **Import** เพื่อเลือกไฟล์ `.json` ด้านบน
2. **การเข้าสู่ระบบ:** เรียก API ในโฟลเดอร์ `Auth` (Login Staff หรือ Public)
3. **ระบบ Token อัตโนมัติ:** เมื่อ Login สำเร็จ ระบบจะบันทึก `{{token}}` ลงในตัวแปรของ Collection ให้โดยอัตโนมัติ คุณสามารถกดเรียก API อื่นๆ (เช่น ยื่นคำขอ หรือ ตรวจสอบรายการ) ต่อได้ทันทีโดยไม่ต้องก๊อปปี้ Token เอง

---

## 📂 โครงสร้างโปรเจกต์ (Project Structure)
```text
.
├── backend/               # โฟลเดอร์ซอร์สโค้ด Laravel
│   ├── public/postman/    # Postman สำหรับทดสอบระบบออนไลน์ (Live)
│   ├── app/               # Logic หลัก (Controllers, Services)
│   └── routes/            # เส้นทาง API
├── postman/               # Postman สำหรับทดสอบในเครื่องตัวเอง (Local)
└── docker-compose.yml     # ไฟล์ตั้งค่าสำหรับรัน Docker ในเครื่อง
```
