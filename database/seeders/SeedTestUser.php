<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeedTestUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test User',
            'email' => 'a@a',
            'password' => \Hash::make('qwe'),
            'email_verified_at' => now()->format('Y-m-d H:i:s'),
            'remember_token' => null,
        ]);
    }
}
