<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Document;
use Faker\Generator as Faker;
use App\Models\Category;

$factory->define(Document::class, function (Faker $faker) {
    $categories = array_values(Category::where('id', '>', 0)->pluck('id')->toArray());

    array_push($categories, null);

    return [
        'name' => $faker->md5,
        'url' => $faker->url,
        'category_id' => $categories[array_rand($categories)]
    ];
});
