<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'), 
        ]);

        User::create([
            'name' => 'Marc',
            'email' => 'a23marciucar@inspedralbes.cat',
            'password' => Hash::make('123456'),
        ]);
    }
}
