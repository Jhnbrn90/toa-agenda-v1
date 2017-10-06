<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'John',
            'email' => 'jbraunnl@gmail.com',
            'shortname' => 'jbn',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        DB::table('users')->insert([
            'name' => 'Linda',
            'email' => 'l.wijsman@msa.nl',
            'shortname' => 'wil',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

    }
}
