<p align="center">## movies api task</p>


## install project 
- create database movies_api
- php artisan migrate 
- composer install 
- composer dump-autoload


## movies_api

- first run local server by : php artisan serv 

- run cron seeds by : php artisan schedule:work

- http://127.0.0.1:8000/api/movies?category_id=12&popular|desc&rated|asc get movies that belongs to category id 12 and order desc by popularity and order asc by top rated
