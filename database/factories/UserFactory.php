<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Usertype;
use App\Room;
use App\Table;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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


$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => 'ADMIN',
        'email' => 'admin@techware.com.np',
        'user_code' => '1234564',
        'phone' => '9852012345',
        'address' => 'Nepal',
        'email_verified_at' => now(),
        'password' => '$2y$10$eAEF24Uto64jknFqlzRgXOZA7tWIiWNo3NB3dSpgkzQseTHOL7aIK', //admin123
        'date_of_join' => date('Y-m-d'),
        'date' => date('Y-m-d'),
        'date_np' => date('Y-m-d'),
        'time' => date('H:i:s'),
        'user_type' => '1',
        'type_id' => '0',
        'user_type_id' => '1',
        'is_active' => '1',
        // 'created_by' => '1',
        'created_at' => date('Y-m-d H:i:s'),
    ];
});

$factory->define(Room::class, function (Faker $faker) {
    return [
        'room_type' => 'none',
        'slug' => 'none',
        'room_no' => 'none',
        'no_of_bed' => '0',
        'price' => '0',
        'is_available' => '0',
        'is_active' => '1',
        'date_np' => date('Y-m-d'),
        'date' => date('Y-m-d'),
        'time' => date('H:i:s'),
        'created_by' => '1',
        'created_at' => date('Y-m-d H:i:s'),
    ];
});

$factory->define(Table::class, function (Faker $faker) {
    return [
        'name' => 'none',
        'slug' => 'none',
        'is_active' => '1',
        'date' => date('Y-m-d'),
        'date_np' => date('Y-m-d'),
        'time' => date('H:i:s'),
        'created_by' => '1',
        'created_at' => date('Y-m-d H:i:s'),
    ];
});
