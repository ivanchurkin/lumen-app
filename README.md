## Установка

Клонируем репозиторий:
```
➜ cd ~
➜ git clone https://github.com/ivanchurkin/lumen-app
```

Устанавливаем зависимости:
```
➜ cd ~/lumen-app
➜ docker run --rm -v $(pwd)/source:/app composer install
```

Определяем переменные окружения:
```
➜ cp source/.env.example source/.env
```

В `source/.env` необходимо указать правильные значения переменных для успешного подключения к базе данных.

```
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=lumen
DB_USERNAME=postgres
DB_PASSWORD=secret
```

Запускаем контейнер
```
➜ docker-compose up -d
```

Если всё выполнилось успешно, то на http://localhost нас ждёт следующая ошибка:

```
SQLSTATE[42P01]: Undefined table: 7 ERROR: relation "users" does not exist LINE 1: SELECT * FROM users ^ (SQL: SELECT * FROM users)
```

Как видно из сообщения в базе нет таблицы `users`. Давайте добавим:

```
➜ docker-compose exec app php artisan migrate

Migration table created successfully.
Migrating: 2020_01_10_234101_create_users_table
Migrated:  2020_01_10_234101_create_users_table (0.04 seconds)
```

Так же заполним таблицу записями:

```
➜ docker-compose exec app php artisan db:seed

Seeding: UsersTableSeeder
Seeded:  UsersTableSeeder (0.28 seconds)
Database seeding completed successfully.
```

Снова перейдём на http://localhost и теперь увидим в ответе массив записей (пользователей) из таблицы `users`.

## ToDo

Нужно (по моему мнению):

- убрать из Dockerfile все ненужные зависимости (то что не используется и добавлять по мере необходимости)
