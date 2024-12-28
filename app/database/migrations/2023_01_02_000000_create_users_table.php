<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });

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
                    'password' => Hash::make('Ap2020@#'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'role' => 'editor'
                ],
                [
                    'name' => 'Editor2',
                    'email' => 'editor2@example.com',
                    'password' => Hash::make('Ep2020@#'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'role' => 'editor'
                ]
            ]);
        }

        if (!Schema::hasColumn('users', 'role')) {
            // The "users" table exists and has an "email" column...
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('editor');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
