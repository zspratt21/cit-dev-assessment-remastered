<?php

namespace App\Commands\User;

use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use App\User;
use LaravelZero\Framework\Commands\Command;

class ListUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users in the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            if (User::exists()) {
                $users = User::all();
                $this->table(['ID', 'Name', 'Email'], $users->map(function (User $user) {
                    return [
                        $user->id,
                        $user->full_name(),
                        $user->email,
                    ];
                }));
            } else {
                $this->warn('No users found. Add some with the user:add command.');
            }
        } catch (DatabaseConnectionException|MissingTableException $e) {
            $this->error('Error listing users');
            $this->error($e->getMessage());
        }
    }
}
