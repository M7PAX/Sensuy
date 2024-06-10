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
        $users = User::factory()->count(6)->create();
        $admin = User::factory()->create([
            'username' => 'admin',
            'is_admin' => true,
            'email' => 'admin@admin.com',
        ]);
    }
}
