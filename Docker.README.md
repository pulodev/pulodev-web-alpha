## Setup dengan Docker
1. Install Docker
2. Gunakan `.env.docker` sebagai `.env` file
3. Build  image dengan `docker-compose build app`
4. Jalankan container services dengan `docker-compose up -d`
5. Install dependencies di dalam container app dengan `docker-compose exec app composer install && npm install`
6. Bila database belum setup jalankan `docker-compose exec app composer php artisan migrate`
7. Check app di http://localhost:8000

## Database configuration
Database secara default akan tersimpan di `docker-compose/data`