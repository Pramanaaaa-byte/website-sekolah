# EduSpace

EduSpace adalah aplikasi manajemen sekolah berbasis Laravel yang dirancang untuk membantu pengelolaan data dan aktivitas sekolah secara terpusat dan efisien.

---

## Deskripsi

Aplikasi ini digunakan untuk mengelola data siswa, guru, serta berbagai aktivitas sekolah seperti piket, izin, dan pelanggaran.
Dengan sistem autentikasi berbasis role, setiap pengguna memiliki akses sesuai dengan kebutuhannya.

---

## Fitur

### Manajemen Data

* CRUD data siswa
* CRUD data guru
* Relasi database (foreign key)

### Aktivitas Sekolah

* Piket harian
* Izin keluar
* Keterlambatan
* Rekap pelanggaran

### Sistem Login

* Multi role (Admin & Guru)
* Middleware berbasis role
* Autentikasi Laravel

---

## Teknologi

* Laravel
* PHP
* MySQL / SQLite
* Blade Template
* Bootstrap / Tailwind

---

## Instalasi

```bash
git clone https://github.com/username/eduspace.git
cd eduspace
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## Struktur Project

```
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
├── Models/

database/
├── migrations/

resources/
├── views/

routes/
├── web.php
```

---

## Status

Project ini masih dalam tahap pengembangan dan akan terus diperbarui.

---

## Catatan

Silakan gunakan dan kembangkan project ini sesuai kebutuhan.
