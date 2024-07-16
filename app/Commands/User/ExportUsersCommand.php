<?php

namespace App\Commands\User;

use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use App\Handlers\File\FileHandler;
use App\User;
use InvalidArgumentException;
use LaravelZero\Framework\Commands\Command;

class ExportUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:export {file}';

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
            $this->info('Exporting users...');
            $file_name = $this->argument('file');
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            match ($extension) {
                'csv' => $users = User::export(User::all())->toCsv(),
                'json' => $users = User::export(User::all())->toJson(),
                default => throw new InvalidArgumentException('Invalid file format. Please use csv or json.'),
            };
            $file = new FileHandler($file_name);
            $file->write($users);
            $this->info("Successfully exported users to $file_name");
        } catch (DatabaseConnectionException|MissingTableException|InvalidArgumentException $e) {
            $this->error('Error exporting users');
            $this->error($e->getMessage());
        }
    }
}
