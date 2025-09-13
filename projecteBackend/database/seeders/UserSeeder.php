<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use Database\Factories\OperatorUserFactory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'coordinator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::COORDINATOR,
            'surnames' => 'Doe',
            'phone' => '123456789',
            'hireDate' => '2023-01-01',
            'terminationDate' => null,
            'username' => 'coordinator123',
        ]);

        User::factory(10)->create();
    }
}
