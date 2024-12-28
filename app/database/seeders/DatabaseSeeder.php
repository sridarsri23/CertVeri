<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
          // Insert default admin and editor accounts
          DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('Ap2020@#'),
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'admin'
            ],
            [
                'name' => 'Editor',
                'email' => 'editor@example.com',
                'password' => Hash::make('Ep2020@#'),
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'editor'
            ]
        ]);
    }
}
