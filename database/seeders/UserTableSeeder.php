<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Create an admin user
        DB::table('users')->insert([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        // Create a vendor user
        DB::table('users')->insert([
            'name' => 'Vendor User',
            'username' => 'vendor',
            'email' => 'vendor@gmail.com',
            'role' => 'vendor',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        // Create regular users
        for ($i=0; $i<10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'username' => $faker->userName,
                'email' => $faker->safeEmail,
                'role' => 'user',
                'status' => $faker->randomElement(['active', 'inactive']),
                'password' => Hash::make('password'),
            ]);
        }
    }
}
