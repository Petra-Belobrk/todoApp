<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence(5, true),
        'best_before' => \Carbon\Carbon::now()->addDays(3)
    ];
});
