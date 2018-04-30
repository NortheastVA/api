<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("users")->insert([
            'firstname' => 'Rahul',
            'lastname' => 'Parkar',
            'email' => 'rahul.a.parkar@gmail.com',
            'pilotnumber' => 9998,
            'title' => 'CTO.0',
            'location' => 'EGLL',
            'base' => 'KBOS',
            'password' => \Hash::make("test12345")
        ]);
        \DB::table("users")->insert([
            'firstname' => 'Daniel',
            'lastname' => 'Hawton',
            'email' => 'dhawton@gmail.com',
            'pilotnumber' => 9999,
            'title' => 'CTO.1',
            'location' => 'PAFA',
            'base' => 'KSEA',
            'password' => \Hash::make("test1234")
        ]);
    }
}
