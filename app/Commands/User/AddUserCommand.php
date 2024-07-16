<?php

namespace App\Commands\User;

use App\UserCommand;

class AddUserCommand extends UserCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add {name} {surname} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new user to the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Adding user...');
        $this->addUser($this->argument('name'), $this->argument('surname'), $this->argument('email'));
    }
}
