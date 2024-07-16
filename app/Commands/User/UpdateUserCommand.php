<?php

namespace App\Commands\User;

use App\User;
use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use InvalidArgumentException;
use LaravelZero\Framework\Commands\Command;

class UpdateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update {id} {--name=} {--surname=} {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a user in the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $user = User::find($this->argument('id'));
            if ($user) {
                if ($this->option('name') || $this->option('surname') || $this->option('email')) {
                    if ($this->option('name')) {
                        $user->first_name = $this->option('name');
                    }
                    if ($this->option('surname')) {
                        $user->last_name = $this->option('surname');
                    }
                    if ($this->option('email')) {
                        $user->email = $this->option('email');
                    }

                    $user->save();
                    $this->info("User {$user->full_name()} updated successfully");
                } else {
                    $this->warn('No changes were provided.');
                }
            } else {
                $this->error('User not found');
            }
        } catch (DatabaseConnectionException|MissingTableException|InvalidArgumentException $e) {
            $this->error('Error updating user');
            $this->error($e->getMessage());
        }
    }
}
