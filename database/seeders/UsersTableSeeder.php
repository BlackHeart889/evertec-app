<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Tienda',
            'mobile' => '3005121058',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::where('email', 'admin@gmail.com')->first()->assignRole('administrador');

    }
}
