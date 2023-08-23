<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
           'first_name'=>'Super',
           'last_name'=>'Admin',
           'email'=>'bogdanburci81@gmail.com',
           'phone'=>'0726735659',
           'password'=>Hash::make('Admin!')
        ]);

        //$user->assignRole(['super-admin']);

    }
}
