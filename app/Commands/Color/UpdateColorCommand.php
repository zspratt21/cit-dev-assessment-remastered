<?php

namespace App\Commands\Color;

use App\Color;
use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use LaravelZero\Framework\Commands\Command;

class UpdateColorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'color:update {id} {--name=} {--hex=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a color in the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $color = Color::find($this->argument('id'));
            if ($color) {
                if ($this->option('name') || $this->option('hex')) {
                    if ($this->option('name')) {
                        $color->name = $this->option('name');
                    }
                    if ($this->option('hex')) {
                        $color->hex = $this->option('hex');
                    }

                    $color->save();
                    $this->info("Color {$color->name} updated successfully");
                } else {
                    $this->warn('No changes were provided. Use --name or --hex to update the color.');
                }
            } else {
                $this->error('Color not found');
            }
        } catch (DatabaseConnectionException|MissingTableException $e) {
            $this->error('Error updating color');
            $this->error($e->getMessage());
        }
    }
}
