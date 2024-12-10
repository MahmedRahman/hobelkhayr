<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update or create admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Find by email
            [
                'name' => 'admin',
                'phone' => '01002089079',
                'password' => Hash::make('admin'),  // Reset password to 'admin'
                'role' => 'admin'
            ]
        );

        $this->command->info('Admin user has been created/updated with password: admin');
    }
}