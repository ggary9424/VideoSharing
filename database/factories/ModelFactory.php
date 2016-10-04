<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\Video::class, function (Faker\Generator $faker) {
    return [
        'user_id' => rand(1, 50),
        'name' => $faker->word,
        'type' => 'video/mp4',
        'views' => rand(200,200000),
    ];
});
