## Что имеем

* lumen (last version)
* nginx (last version)
* postgresql (last version)
* php:7.2-fpm

Контейнер собран по [следующей](https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose) инструкции. Отступления касаются использования postgresql вместо mysql в качестве основной базы данных.

## Запуск

Выполняем команду:
```
docker-compose up -d
```
Успешный результат выполнения:
```
➜ docker-compose up -d
Creating network "lumen-app_app-network" with driver "bridge"
Creating webserver ... done
Creating db        ... done
Creating app       ... done
```

Далее открываем http://localhost и наблюдаем ошибку базы данных о несуществующей таблице users.

Для решения "проблемы" выполняем:

```
➜ docker-compose exec app php artisan migrate
```

После:

```
➜ docker-compose exec app php artisan db:seed
```

Результатом выполнения этих команд должна являться вновь созданная таблица users с двумя пользователями. Если всё получилось, то на странице http://localhost вы должны увидеть ответ с сервеа (массив пользователей).

## Послесловие

Нужно (по моему мнению):
- пересмотреть организацию файловой структуры проекта выделить сам lumen в отдельную папку (например "src")
- убрать из Dockerfile все ненужные зависимости (то что не используется и добавлять по мере необходимости)
