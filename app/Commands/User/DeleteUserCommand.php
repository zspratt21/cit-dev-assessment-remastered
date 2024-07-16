<?php

namespace App\Commands\User;

use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use App\User;
use LaravelZero\Framework\Commands\Command;

class DeleteUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a User by Id';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $user = User::find($this->argument('id'));
            if ($user) {
                $user->delete();
                $this->info("User {$user->full_name()} deleted successfully");
            } else {
                $this->error('User not found');
            }
        } catch (DatabaseConnectionException|MissingTableException $e) {
            $this->error('Error deleting user');
            $this->error($e->getMessage());
        }
    }
}
