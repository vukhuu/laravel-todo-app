## About
This is a simple todo app implemented with Laravel (5.8) and VueJS 2.0 with TDD applied

## Installation
Please check for requirements to run Laravel 5.8 at https://laravel.com/docs/5.8/installation

Copy `.env.example` to `.env`

Create a database named `todo` and `todo_testing` and change the `.env` file and `phpunit.xml` accordingly to reflect your database credential

Run `composer install`

Run `npm install`

Seed user data using `php artisan db:seed`

Run `php artisan serve`

Access `localhost:8000/main`

Default user to log in is `jon.snow@gmail.com`, `thisisadmin`. Please feel free to register for a new user.

Unit test can be run by executung `vendor\bin\phpunit`

Thanks,
