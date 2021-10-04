<p align="center">movies_api</p>


## install project 
- create database movies_api
- php artisan migrate 
- composer install 
- composer dump-autoload


#movies_api

- first run cron seeds by : php artisan schedule:work

- run local server by : php artisan serv

- http://127.0.0.1:8000/api/movies?category_id=12&popular|desc&rated|asc get movies that belongs to category id 12 and order desc by popularity and order asc by top rated
