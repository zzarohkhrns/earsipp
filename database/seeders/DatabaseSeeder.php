<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;


use Illuminate\Support\Facades\Hash;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // User
        User::create([
            'id' => '1',
            'username' => 'lazisnu',
            'password' => Hash::make('1234'),
            'role' => 'admin',
        ]);
    }
}
