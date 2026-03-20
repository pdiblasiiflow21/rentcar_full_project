<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin2',
            'email' => 'admin2@admin.com',
            'password' => Hash::make('123456'),
            'role'=> 'admin',
            'remember_token'=> '',

        ]);
    }
}
