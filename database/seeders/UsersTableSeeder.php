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
            'role_id' => 1,
            'identification' => '001'
        ]);
        UserDetail::create([
            'user_id' => $user1->id,
            'role_id' => 1,
            'name' => 'Doctor 1',
            'age' => 1,
            'phone' => '123456789',
            'gender' => 'M',
            'birthday' => '2024-04-04',
        ]);
        $user2 = User::create([
            'name' => 'Doctor Dos',
            'email' => 'doctor2@test.com',
            'password' => Hash::make('1234'), 
            'role_id' => 1,
            'identification' => '002'
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
            'name' => 'Asistente',
            'email' => 'asistente@asistente.com',
            'password' => Hash::make('1234'),
            'role_id' => 1,
            'identification' => '003' 
        ]);
        UserDetail::create([
            'user_id' => $user3->id,
            'role_id' => 2,
            'name' => 'Asistente',
            'age' => 1,
            'phone' => '123456789',
            'gender' => 'F',
            'birthday' => '2024-04-04',
        ]);       
        $user4 = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('1234'),
            'role_id' => 3,
            'identification' => '000' 
        ]);
        UserDetail::create([
            'user_id' => $user4->id,
            'role_id' => 3,
            'name' => 'Admin',
            'age' => 1,
            'phone' => '123456789',
            'gender' => 'F',
            'birthday' => '2024-04-04',
        ]);
    }
}
