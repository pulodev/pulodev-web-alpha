## Proyek PuloDev

Baca di [trello](https://trello.com/b/7SI1Qe1T/version-1)

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

## Admin
Di app ini ada user biasa, ada admin. Admin bisa mengakses API dan juga dashboard

### Dashboard admin
Di dashboard ini, admin bisa melihat list link yang menjadi draft. Bisa dipublish atau dihapus jika tidak memenuhi syarat
- /admin/dashboard

## Petunjuk menguji API
Api menggunakan laravel/passport
- Jalankan ' php artisan passport:install ' 

### Endpoint API
Perlu menjadi admin untuk mengakses ini. Cara jadi admin via Database. Table users -> role = 1
- Login: [POST] /api/login
- Link : [POST] /api/link
- RSS List: [get] /api/resources ==> semua data akan diambil, limit akan diset 90000
- RSS List with limit: [get] /api/resources?limit=10&page=1 ==> 10 data pertama akan ditampilkan, untuk mengambil data berikutnya cukup menganti page. exp 'page=2'

### Testing manual Login API 
Untuk mendapatkan token, akses via postman (atau yang lain) 
- Metode POST : url/api/login
- Di bagian 'body > x-www-form-urlencoded'
- Masukkan credential yang sudah didaftarkan sebelumnya (username dan password) 
- (opsional) jika error masalah keys, jalankan ' php artisan passport:keys '

### Asumsi requestion dari agregator

Saat post Link, sertakan rss_id dan bungkus konten di dalam "items"
````
{
    "rss_id" : 1,
    "items": [
        {
            "title": "konten satu",
            "link": "google.com/blog/satu",
            "description": "maju tak gentar"
        },
        {
            "title": "konten dua",
            "link": "dua.com/blog/dua",
            "description": "dua tak gentar"
        }
    ]
}
```

## Testing Manual
Testing using phpunit. Location: /tests

### SetUp Test
- copy .env to .env.testing
(sediakan DB baru)
- php artisan --env=testing migrate
migrate table di DB baru untuk testing
- jalankan "vendor/bin/phpunit" atau "phpunit" untuk testing
