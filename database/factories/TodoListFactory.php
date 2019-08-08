<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TodoList;
use Faker\Generator as Faker;

$factory->define(TodoList::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(100),
        'owner_id' => auth()->id(),
    ];
});
