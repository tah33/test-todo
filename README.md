This is a test Todo App made with Laravel 12 and vue 3. Please follow the below steps to install

1. Clone this project
2. Make sure you've php 8.2 or above
3. run `composer install`
4. creat .env file from .env.example by command `cp .env.example .env`
5. Adjust your database credential
6. run `php artisan key:generate`
7. run `php artisan migrate`
8. install npm with `npm i` (latest version was recommend)
9. run `composer run dev`
10. You can now access you application at http://127.0.0.1:8000/login
11. For automated Testing <br>
    -> install dusk `php artisan dusk:install` <br>
    -> If you want to run in test in browser use `php artisan dusk --env=dusk.local` <br>
    -> If you want to run in CLI use `php artisan dusk` <br>
