#!/bin/sh

# รัน Migration และ Seed เฉพาะเมื่อจำเป็น (บน Production)
# --force สำคัญมาก เพื่อไม่ให้ระบบหยุดถามยืนยัน
echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

# เคลียร์ Cache เพื่อความสดใหม่ของข้อมูล
php artisan config:cache
php artisan route:cache

# เริ่มต้นรัน Server โดยใช้ PORT ที่ Cloud กำหนดมาให้ (ถ้าไม่มีจะใช้ 8000)
PORT=${PORT:-8000}
echo "Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT
