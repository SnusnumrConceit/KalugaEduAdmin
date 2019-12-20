<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {

    $categories = array_values(Category::where('id', '>', 0)->pluck('id')->toArray());

    array_push($categories, null);

    return [
        'name' => $faker->unique()->safeColorName,
        'slug' => $faker->title,
        'parent_id' => $categories[array_rand($categories)]
    ];
});
