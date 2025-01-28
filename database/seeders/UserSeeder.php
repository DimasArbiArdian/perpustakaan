<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'nama'=>'admin',
            'alamat'=>'xxxx',
            'telepon'=>'12345',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('admin@123'),
            'jenis'=>'admin'
        ]);
    }
}
