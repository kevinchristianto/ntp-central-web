<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Admin',
            'username' => 'ADMIN',
            'password' => bcrypt('admin'),
            'is_active' => true,
            'created_by' => 1
        ];

        User::createQuietly($data);
    }
}
