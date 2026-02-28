<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the admin account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@internship.com'],
            [
                'name'     => 'Super Admin',
                'email'    => 'admin@internship.com',
                'password' => Hash::make('Admin@1234'),
                'role'     => 'admin',
                'status'   => 'active',
            ]
        );

        $this->command->info('✅ Admin account created:');
        $this->command->info('   Email:    admin@internship.com');
        $this->command->info('   Password: Admin@1234');
        $this->command->warn('   ⚠️  Please change the password after first login!');
    }
}
