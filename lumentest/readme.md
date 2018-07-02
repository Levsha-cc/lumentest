# Тестовое задание

## Технологии

В качестве PHP-движка выбрал микрофреймворк [Lumen](http://lumen.laravel.com/) от Laravel.

Для установки нужно использовать composer

```bash
composer install
```

Необходимо настроить доступы к БД в файле `.env` . Мои настройки выглядят так:

```config
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=lumenlogs
DB_USERNAME=postgres
DB_PASSWORD=
```

Так же использовал:
* PHP 7.1
* PostgreSQL 10.1
* Bootstrap 4
* ExtJS 6
 

## Логи

2 файла логов находятся в папке `/public`:
* [users.log](/lumentest/public/users.log)
* [story.log](/lumentest/public/story.log)

Так как логов предоставлено не было, я сделал генератор логов, который доступен по 
URL [/logs_create](http://lumentest/logs_create) и позволяет сгенерировать логи на 25, 50, 100, 200 
или 500 пользователей. 

Я разрабатывал на windows, под linux могут быть проблемы с записью, необходимо добавить 
права на запись в папку `/public`. Знаю что нехорошо, сделал в угоду наглядности, чтобы 
логи лекго открывались через браузер. 


## База данных

Скрипт для создания таблиц:

```sql

\connect "lumenlogs";

DROP TABLE IF EXISTS "story";
CREATE TABLE "public"."story" (
    "date" timestamp NOT NULL,
    "ip" cidr NOT NULL,
    "url_from" text NOT NULL,
    "url_to" text NOT NULL,
    CONSTRAINT "story_ip_fkey" FOREIGN KEY (ip) REFERENCES users(ip) NOT DEFERRABLE
) WITH (oids = false);


CREATE INDEX "story_ip" ON "public"."story" USING btree ("ip");


DROP TABLE IF EXISTS "users";
CREATE TABLE "public"."users" (
    "ip" cidr NOT NULL,
    "browser" character(255) NOT NULL,
    "os" character(25) NOT NULL,
    CONSTRAINT "users_ip" UNIQUE ("ip")
) WITH (oids = false);
```

Этот же скрипт описан в файле [/dump.sql](/lumentest/dump.sql)

Импорт логов в БД расположен по URL [/db_import](http://lumentest/db_import)

Ключевой запрос для таблицы выглядит так:

```sql
SELECT distinct on (users.ip) 
  users.ip, users.browser, users.os, story.url_from, lastStory.url_to, 
  COUNT(*) over(partition by story.ip order by story.date)
FROM users 
LEFT JOIN story ON users.ip = story.ip
LEFT JOIN story as lastStory ON users.ip = lastStory.ip
order by users.ip, story.date ASC, lastStory DESC
```

## ExtJS

Таблица ExtJS расположена по URL [/tablejs](http://lumentest/tablejs)

Просто HTML таблица для "сверки" доступна по URL [/table](http://lumentest/table)

## Интерфейс

Все разделы доступны в верхнем правом меню: Логи, БД, Таблица, ExtJS. 
Дополнительные функции расположены на кнопках в этих разделах.

Такие функции как **генерация новых логов** или **импорт логов в БД** сделаны отдельными 
независимыми методами. Это позволяет повесить их на комманду в CLI,
например 

```
php artisan logs::generate
``` 

Сами команды реализовывать не стал, так как задания не было, но архитектуру 
предусмотрел на будущее. 


## Файлы измененные/созданные мной

* `routes/web.php` - основные роутеры, направляющие URL на контроллер
* `app/Http/Controllers/LogsController.php` , 
`app/Http/Controllers/PDBController.php` - контроллеры, берут данные 
из моделей и передают во вьюшку. 
Не представляют интереса :)
* `app/Logs.php` - модель для логов. Предоставляет информацию 
о текущих логах и геренирует новые логи.
* `app/PDB.php` - модель для БД. Предоставляет информацию о текущих 
таблицах, импортирует логи в БД, осуществляет основной запрос к БД.
* в папке `resources/views` все вьюшки.
* скрипт описывающий ExtJS находится в файле `resources/views/tablejs.blade.php`

Вроде все.