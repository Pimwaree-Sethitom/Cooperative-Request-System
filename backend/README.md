# Cooperative Request System (Backend)

ระบบยื่นคำขอจัดตั้งสหกรณ์ (Backend API) พัฒนาด้วย Laravel 12 และ Docker

## 🚀 วิธีการรันโปรเจกต์ (Getting Started)

### 1. เตรียมไฟล์สภาพแวดล้อม (.env)
คัดลอกไฟล์ `.env.example` ไปเป็น `.env` และตั้งค่าฐานข้อมูลให้ตรงกับ Docker:
```bash
cp .env.example .env
```
**ค่าที่ต้องตรวจสอบใน .env:**
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=cooperative_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_password
```

### 2. รันระบบผ่าน Docker
ใช้คำสั่ง Docker Compose เพื่อสร้างและรัน Container:
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

- **Base URL:** `http://localhost:8000/api`
- **การยืนยันตัวตน:** ใช้ **Bearer Token** (จะได้หลังจาก Login สำเร็จ)
- **โครงสร้าง Response:**
  ```json
  {
      "status": "success",
      "message": "...",
      "data": { ... },
      "errors": null
  }
  ```

---

## 📂 โครงสร้างโปรเจกต์ (Project Structure)

```text
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/   # ตัวควบคุม Request/Response
│   │   └── Responses/     # มาตรฐานรูปแบบ API Response
│   ├── Models/            # โมเดลฐานข้อมูล (User, Cooperative, etc.)
│   └── Services/          # ส่วนจัดการ Business Logic (Service Layer)
├── database/
│   ├── migrations/        # ไฟล์ออกแบบตารางฐานข้อมูล
│   └── seeders/           # ไฟล์ข้อมูลเริ่มต้นของระบบ
└── routes/
    └── api.php            # เส้นทางเชื่อมต่อ API ทั้งหมด
```
