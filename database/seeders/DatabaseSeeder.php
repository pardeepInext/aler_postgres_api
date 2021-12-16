<?php

use App\Models\User;
use Database\Seeders\CountrySeeder;
use Database\Seeders\StateSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\BlogSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PropertySeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            RoleSeeder::class,
            BlogSeeder::class,
            UserSeeder::class,
        ]);
    }
}
