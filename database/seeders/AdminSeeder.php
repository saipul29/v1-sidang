<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Staf Prodi Admin',
            'email' => 'admin@gunadarma.ac.id',
            'password' => Hash::make('admin123'), // Password untuk login admin
            'role' => 'admin',
        ]);
    }
}