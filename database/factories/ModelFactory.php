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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

//create posts seed
$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentences(mt_rand(1, 3), true),
        'content' => join("\n\n", $faker->paragraphs(mt_rand(5, 30))),
        'updated_at' => $faker->dateTimeBetween('+1 days', '+3 days'),
        'user_id' => mt_rand(1, 3),
        'category_id' => mt_rand(1, 3),
    ];
});

//create tags seed
$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'tag_name' => $faker->words(1, true),
    ];
});
//create categories seed
$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'category_name' => $faker->words(1, true),
    ];
});

$factory->define(App\Nav::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words(1, true),
        'url' => '/',
        'flag' => $faker->boolean(50),
        'icon' => '',
    ];
});