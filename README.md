
## Proyek KodingCLub

Baca di [trello](https://trello.com/b/jhDIV1CH/beta-dev)

## Setup Project
- download repository ini
- composer install
- npm install
- Bikin file .env (copy isinya dari .env.example)
- Siapkan database (mysql) sesuaikan namanya DB, user, pass di file .env sebelumnya
- jalankan "php artisan migrate" untuk mengisi kolom database
- Untuk verifikasi email (simulasi), daftar di mailtrap.io dan copy key nya ke file .env
- jalankan "php artisan serve", untuk menjalankan server, lihat di http://localhost:8000

## Informasi
- Ada fungsi general di app/helper.php (untuk fungsi yang bisa diakses dari mana saja)
