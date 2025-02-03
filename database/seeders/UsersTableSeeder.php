<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Admin
       DB::table('users')->insert([
        [
            'name'=> 'Admin',
            'username'=> 'admin',
            'email'=> 'admin@gmail.com',
            'role'=> 'admin',
            'status'=> 'active',
            'password'=> Hash::make('111'),
        ],
        [
            'name'=> 'Vendor',
            'username'=> 'vendor',
            'email'=> 'vendor@gmail.com',
            'role'=> 'vendor',
            'status'=> 'active',
            'password'=> Hash::make('111'),
        ],
        [
            'name'=> 'User',
            'username'=> 'user',
            'email'=> 'user@gmail.com',
            'role'=> 'user',
            'status'=> 'active',
            'password'=> Hash::make('111'),
        ]
    ]);
    }
}
