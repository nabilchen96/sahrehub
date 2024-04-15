<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Nabil Chen', 
            'email' => 'nabil_chen@gmail.com', 
            'password' => Hash::make('zaq12wsx'),
            'photo' => 'avatar.png',
            'role' => 'Admin'
        ]);
    }
}
