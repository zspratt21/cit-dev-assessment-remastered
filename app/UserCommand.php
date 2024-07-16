<?php

namespace App;

use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use InvalidArgumentException;
use LaravelZero\Framework\Commands\Command;

class UserCommand extends Command
{
    protected function addUser(string $first_name, string $last_name, string $email) : void {
        try {
            $user = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
            ]);
            $this->info("User {$user->full_name()} added successfully");
        } catch (DatabaseConnectionException|MissingTableException|InvalidArgumentException $e) {
            $this->error('Error adding user');
            $this->error($e->getMessage());
        }
    }
}
