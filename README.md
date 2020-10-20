Окружение:

Apache 2.4 (PHP 7.2-7.4);
PHP 7.4;

PostgreSQL 12.2;

Инструкция по запуску:

1) git clone https://github.com/GromoVlad/Rusbitech.git

2) cd Rusbitech

3) php composer.phar update

4) npm install

5) скопировать файл .env.example переименовав его в .env

6) сгенерировать ключ — php artisan key:generate

7) создать в Postgres БД с именем rusbitech 

8) запустить миграции — php artisan migrate

9) готово!

по настройкам сайт должен открыться по url: http://rusbitech 

документация находится по url: http://rusbitech/api/documentation
