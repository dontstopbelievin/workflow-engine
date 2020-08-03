<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Template;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Template::class, function (Faker $faker) {
    return [
        'name' => $faker->bs,
        'doc_path' => Str::random(15).'.jpg',
        'accept_template' =>  (bool)random_int(0, 1),
    ];
});
