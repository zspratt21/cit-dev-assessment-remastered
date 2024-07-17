<?php

namespace App\Commands\User;

use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\MissingTableException;
use App\Handlers\File\FileHandler;
use App\User;
use App\UserCommand;
use InvalidArgumentException;

class ImportUsersCommand extends UserCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from a file into the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $file_name = $this->argument('file');
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $file = new FileHandler($file_name);
            $contents = $file->read();
            $users = match ($extension) {
                'csv' => User::importFromCsv($contents),
                'json' => User::importFromJson($contents),
                default => throw new InvalidArgumentException('Invalid file format. Please use csv or json.'),
            };
            $quantity = count($users);
            $this->info("Importing $quantity users...");
            foreach ($users as $user) {
                $this->addUser($user['name'], $user['surname'], $user['email']);
            }
            $this->info("Finished importing users from $file_name");
        } catch (DatabaseConnectionException|MissingTableException|InvalidArgumentException|FileNotFoundException $e) {
            $this->error('Error importing users');
            $this->error($e->getMessage());
        }
    }
}
