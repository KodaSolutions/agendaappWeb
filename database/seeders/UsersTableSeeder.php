<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserDetail;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user1 = User::create([
            'name' => 'Doctor Uno',
            'email' => 'doctor1@test.com',
            'password' => Hash::make('1234'),
        ]);
        UserDetail::create([
            'user_id' => $user1->id,
            'role_id' => 1,
            'name' => 'test',
            'age' => 1,
            'phone' => '123456789',
            'gender' => 'M',
            'birthday' => '2024-04-04',
        ]);
        $user2 = User::create([
            'name' => 'Doctor Dos',
            'email' => 'doctor2@test.com',
            'password' => Hash::make('1234'), 
        ]);
        UserDetail::create([
            'user_id' => $user2->id,
            'role_id' => 1,
            'name' => 'test 2',
            'age' => 1,
            'phone' => '123456789',
            'gender' => 'M',
            'birthday' => '2024-04-04',
        ]);        
        $user3 = User::create([
            'name' => 'Dulce',
            'email' => 'dulce@test.com',
            'password' => Hash::make('1234'), 
        ]);
        UserDetail::create([
            'user_id' => $user3->id,
            'role_id' => 2,
            'name' => 'Dulce',
            'age' => 1,
            'phone' => '123456789',
            'gender' => 'F',
            'birthday' => '2024-04-04',
        ]);
    }
}
