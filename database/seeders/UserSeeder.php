<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => '',
                'email' => 'admin@codingoblin.com',
                'password' => '123456789',
                'role' => 'admin'
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Cena',
                'email' => 'john@codingoblin.com',
                'password' => '123456789',
                'role' => 'standard',

            ]
        ];

        foreach ($users as $user) {
            $created_user = User::create([
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
            $created_user->assignRole($user['role']);
        }
    }
}
