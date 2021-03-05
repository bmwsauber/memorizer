<?php

use Modules\Report\Entities\Report;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(Report::class, function (Faker $faker) {

    $right = $faker->numberBetween(0, 50);
    $wrong = $faker->numberBetween(0, 50);
    $total = $right + $wrong;

    return [
        'right' => $right,
        'wrong' => $wrong,
        'total' => $total,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
