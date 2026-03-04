# Website Sekolah - EduSpace

Project ini adalah aplikasi manajemen sekolah berbasis Laravel yang memiliki fitur:

- Manajemen Data Siswa
- Manajemen Data Guru
- Piket
- Izin Keluar
- Keterlambatan
- Login Multi Role

---

## Cara Menjalankan Project

1. Install dependency
composer install

2. Copy file env
cp .env.example .env

3. Generate application key
php artisan key:generate

4. Migrasi database
php artisan migrate

5. Install frontend dependency
npm install

6. Build asset
npm run build

7. Jalankan server
php artisan serve
