### Сторонние сервисы
#### БД
В .env указать креды для подключения к любой удобной для вас СУБД:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=psuti_ctf_web_task_2024
DB_USERNAME=root
DB_PASSWORD=root
```

#### Список возможных драйверов: mysql, pgsql

#### P.S. Можно использовать sqlite, но за него не ручаюсь

### Зависимости
#### Серверная часть
1. **PHP 8.2** + расширение **php8.2-mysql/php8.2-pgsql** в зависимости от выбранной СУБД
2. Composer ^2.*
#### Клиентская часть
1. NPM 10.8.2 + NodeJS 18.19.1 (могут прокатить другие версии)

### Сборка
```shell
# server
composer install
php artisan optimize:clear

# client
npm install
npm run build
```

### Запуск
```shell
php artisan serve
### или
php artisan serve -q # если не хотите видеть логи
```
