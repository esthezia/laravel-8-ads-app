<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        // user admin
        DB::table('users')->insert([
            'is_admin' => 1,
            'name' => $faker->name(),
            'email' => 'admin@yahoo.com',
            'password' => Hash::make('admin123'),
        ]);

        // user normal
        DB::table('users')->insert([
            'is_admin' => 0,
            'name' => $faker->name(),
            'email' => 'user@yahoo.com',
            'password' => Hash::make('user123'),
        ]);
    }
}
