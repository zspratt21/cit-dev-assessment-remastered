<?php

namespace App\Commands\Color;

use App\Color;
use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use LaravelZero\Framework\Commands\Command;

class ListColorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'color:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all colors in the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            if (Color::exists()) {
                $colors = Color::all();
                $this->table(['ID', 'Name', 'Hex'], $colors->map(function ($color) {
                    return [
                        $color->id,
                        $color->name,
                        $color->hex,
                    ];
                }));
            } else {
                $this->warn('No colors found. Add some with the color:add command.');
            }
        } catch (DatabaseConnectionException|MissingTableException $e) {
            $this->error('Error listing colors');
            $this->error($e->getMessage());
        }
    }
}
