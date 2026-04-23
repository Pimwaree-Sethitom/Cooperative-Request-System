# Cooperative Request System

ระบบยื่นคำขอจัดตั้งสหกรณ์ (Backend API) พัฒนาด้วย Laravel 12 และ Docker

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

คุณสามารถนำเข้าไฟล์ **Postman Collection** เพื่อทดสอบ API ได้ทันที:
- **ไฟล์ Collection:** `postman/Cooperative API.postman_collection.json`
- **Base URL:** `http://localhost:8000/api`
- **ขั้นตอน:**
    1. เปิดโปรแกรม Postman
    2. กดปุ่ม **Import** แล้วเลือกไฟล์ด้านบน
    3. เมื่อ Login สำเร็จ **Token จะถูกบันทึกลงตัวแปรอัตโนมัติ** คุณสามารถกดเรียก API อื่นๆ ต่อได้เลย

---

## 📂 โครงสร้างโปรเจกต์ (Project Structure)

```text
.
├── backend/               # โฟลเดอร์ซอร์สโค้ด Laravel
│   ├── app/               # Logic หลักของระบบ
│   ├── database/          # Migrations และ Seeders
│   └── routes/            # เส้นทาง API
├── postman/               # ไฟล์ Postman Collection
└── docker-compose.yml     # ไฟล์ตั้งค่า Docker
```
