<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name'=>'customer1',
                'email'=>'customer1@test.com',
                'password'=> Hash::make('password'),
                'phone'=>'081388367927',
                'address'=>'perum blok a1 no 47'
            ],
            [
                'name'=>'customer2',
                'email'=>'customer2@test.com',
                'password'=> Hash::make('password'),
                'phone'=>'0879451345',
                'address'=>'rawa kutuk blok 2A No 92'
            ]
        ];

        foreach($customers as $user){
            Customer::create($user);
        }
    }
}
