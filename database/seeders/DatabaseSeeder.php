<?php

use App\Models\User;
use Database\Seeders\CountrySeeder;
use Database\Seeders\StateSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\BlogSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create([
            'role_id' => rand(1, 3)
        ]);

        $this->call([
            PropertySeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            RoleSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
