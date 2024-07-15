<?php

namespace App\Commands\Color;

use App\Color;
use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use LaravelZero\Framework\Commands\Command;

class AddColorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'color:add {name} {hex}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new color to the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $color = Color::create([
                'name' => $this->argument('name'),
                'hex' => $this->argument('hex'),
            ]);
            $this->info("Color {$color->name} added successfully");
        } catch (DatabaseConnectionException|MissingTableException $e) {
            $this->error('Error adding color');
            $this->error($e->getMessage());
        }
    }
}
