<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\SongLyrics::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->text(20),
        'artist' => $faker->text(20),
        'lyrics' => $faker->paragraph( 60)
    ];
});
