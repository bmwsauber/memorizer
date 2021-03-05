<?php
use Modules\Work\Entities\Card;
use Modules\Work\Entities\Category;
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
$factory->define(Card::class, function (Faker $faker) {

    $right = $faker->numberBetween(0, 50);
    $wrong = $faker->numberBetween(0, 50);
    $total = $right + $wrong;

    return [
        'eng' => $faker->word,
        'rus' => $faker->word,
        'category_id' => factory(Category::class),
        'level' => $faker->numberBetween(0, $total),
        'right' => $right,
        'wrong' => $wrong,
        'total' => $total,
        'show_only' => null,
        'irreg_verb' => $faker->numberBetween(0, 1),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];

});
