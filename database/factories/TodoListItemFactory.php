<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TodoListItem;
use Faker\Generator as Faker;

$factory->define(TodoListItem::class, function (Faker $faker) {
    return [
        'name' => $faker->realText(100),
    ];
});
