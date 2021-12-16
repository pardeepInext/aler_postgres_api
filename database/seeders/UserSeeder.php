<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $roles = [1, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 2];

        foreach ($roles as $role)
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make(12345678),
                'remember_token' => Str::random(10),
                'role_id' => $role,
            ]);
    }
}
