<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin kullanıcısı
        User::create([
            'name' => 'Merve',
            'surname' => 'İşbilir',
            'email' => '1merveisbilir@gmail.com',
            'password' => Hash::make('19051905'),
            'title' => 'Yönetici',
            'is_superadmin' => true,
        ]);
    }
}
