A simple todo app built with Laravel and VueJS

## Features
Laravel 5.8

VueJS 2.x

TDD

Repository pattern as service providers and dependency injection

Activity logger

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
