# Docker-контейнер

* Nginx (latest)
* PostgreSQL (latest)
* PHP (7.2)
* Laravel (latest)

## Установка

Клонируем репозиторий:
```
➜ cd ~
➜ git clone https://github.com/ivanchurkin/lumen-app
```

Устанавливаем зависимости:
```
➜ cd ~/lumen-app
➜ docker run --rm -v $(pwd)/certs:/usr/local/share/ca-certificates -v $(pwd)/source:/app composer /bin/bash -c "update-ca-certificates && composer install"
```

Определяем переменные окружения:
```
➜ cp source/.env.example source/.env
```

В `source/.env` необходимо указать правильные значения переменных для успешного подключения к базе данных.

```
DB_CONNECTION=pgsql
DB_HOST=db.test
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=postgres
DB_PASSWORD=secret
```

Запускаем контейнер
```
➜ docker-compose up -d
```

Если всё выполнилось успешно, то на http://localhost нас ждёт предупреждение:

```
RuntimeException
No application encryption key has been specified.
```

На этой же странице можем нажать на кнопку `Generate app key` или выполнить команду:

```
➜ docker-compose exec app php artisan key:generate

Application key set successfully.
```

Обновляем http://localhost и видим стартовую страницу Laravel.

## Что дальше?

Выполняем миграции.

```
➜ docker-compose exec app php artisan migrate
```

Генерируем клиента для авторизации пользователей.

```
➜ docker-compose exec app php artisan passport:client --password
```

## ToDo

Нужно (по моему мнению):

- убрать из Dockerfile все ненужные зависимости (то что не используется и добавлять по мере необходимости)
- добавить `npm` (nodejs) в контейнер `app`
- добавить описание для

## FAQ

При выполнение команды:

```
➜ docker-compose exec app composer require { package_name_here }
```

Возникает ошибка. Проверьте права на папку `source/vendor`.
