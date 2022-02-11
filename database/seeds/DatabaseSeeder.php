<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(UserTypeSeeder::class);
        factory(App\User::class,1)->create();
        factory(App\Room::class,1)->create();
        factory(App\Table::class,1)->create();

    }
}
