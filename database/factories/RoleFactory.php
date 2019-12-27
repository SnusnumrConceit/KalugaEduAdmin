<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Kodeine\Acl\Models\Eloquent\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => 'Администратор',
        'slug' => 'admin',
        'description' => 'администратор системы'
    ];
});
