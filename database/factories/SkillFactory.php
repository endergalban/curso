<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Skill;
use Faker\Generator as Faker;

$factory->define(Skill::class, function (Faker $faker) {
    return [
       'name' => $faker->unique()->sentence(3),
    ];
});
