<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\User;

class GenerateApiTokens extends Command
{
    protected $signature = 'tokens:generate';
    protected $description = 'Generate API tokens for all users';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->api_token = Str::random(60);
            $user->save();
        }

        $this->info('API tokens generated successfully.');
    }
}
