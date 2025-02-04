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
            [
                'name' => 'System Scheduler',
                'username' => 'System Scheduler',
                'password' => bcrypt('this isn\'t a password'),
                'is_active' => true,
                'created_by' => 0
            ],
            [
                'name' => 'Admin',
                'username' => 'ADMIN',
                'password' => bcrypt('admin'),
                'is_active' => true,
                'created_by' => 1
            ]
        ];

        User::upsert($data, uniqueBy: ['id']);

    }
}
