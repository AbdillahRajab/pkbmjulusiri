# PKBM Julusiri

Sistem Pendaftaran PKBM Julusiri berbasis Laravel.

## Persyaratan

- PHP 8.2+
- Composer
- MySQL

## Instalasi

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve