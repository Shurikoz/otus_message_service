<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel

1. Развернуть проект, запустить composer
2. Создать БД (mysql)
3. Настроить подключение к БД в [.env](.env) или [database.php](config%2Fdatabase.php)
4. Выполнить миграцию - php artisan migrate
5. Сгенерировать токены безопасности - php artisan passport:install
6. Запустить приложение - php artisan serve

7. Запуск воркеров очередей
   php artisan queue:work --queue=notification
   php artisan queue:work --queue=posts_caching

8. Для запуска Tarantool из каталога tt выполнить tt start create_db
9. 
Запросы на _регистрацию_ | _авторизацию_ | _получение пользователя_ находятся здесь - [user.http](dev%2Fjb_http_client%2Fuser.http)
Токен безопасности, сгенерированный ранее (Laravel Password Grant Client) используется в "client_secret" для авторизации
Для получения пользователя необходимо передать Bearer токен, получаемый при авторизации
