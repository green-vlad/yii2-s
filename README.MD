# Разворачивание и запуск приложения

1. Делаем файл start.sh исполняемым
`chown +x start.sh` и запускаем его
`./start.sh`
2. После сборки контейнеров заходим внутрь контейнера php-fpm 
`docker exec -it yii2-app bash`
3. Выполняем команду 
`composer install`
4. Запускаем выполнение миграций
`php yii migrate`

Приложение запущено на 80м порту.

Остановка приложения
`docker compose down`

5. Запуск unit тестов. Заходим в контейнер
`docker exec -it yii2-app bash`
переходим в директорию basic и запускаем
`vendor/bin/codecept run unit models/TrackTest`

В БД создается 1 пользователь с token=user_access_token

# Примеры использования
## Создание новой записи
`curl --location 'localhost/tracks' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer user_access_token' \
--data '{
"track_number": "tracknumber6"
}'`

## Смена статуса для 1й записи
`curl --location --request PUT 'localhost/tracks/3' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer user_access_token' \
--data '{
"id": 8,
"status": "failed"
}'`

## Удаление 1 записи
`curl --location --request DELETE 'localhost/tracks/1' \
--header 'Authorization: Bearer user_access_token'`

## Получение 1 записи
`curl --location 'localhost/tracks/1' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer user_access_token'`

## Изменение статуса у нескольких записей
`curl --location 'localhost/tracks/bulk-status' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer user_access_token' \
--data '{
"ids": [4, 5, 6],
"status": "canceled"
}'`


# Допущения
## Изменение/редактирование сразу нескольких tracks
Т.к. по этому пункту не было указано требований, то я представил, что данные на редактирование приходят из frontend
в виде ids и на какой статус их нужно поменять.
Наверное, если бы речь шла о нескольких тысячах записей, 
то имело бы смысл подумать над асинхронной реализацией.

## DI container точнее его отсутсвие
Для упрощения я не стал делать внедрение зависимостей через DI в контроллер TrackController
для валидации и для сервиса по-массовому апдейту записей.

## Логирование
Я добавил логирование просто в модель. Для реального приложения сделал бы сервис логирования
и его тоже бы внедрял через DI container

