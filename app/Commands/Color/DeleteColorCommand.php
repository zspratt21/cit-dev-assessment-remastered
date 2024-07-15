<?php

namespace App\Commands\Color;

use App\Color;
use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use LaravelZero\Framework\Commands\Command;

class DeleteColorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'color:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a Color by Id';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $color = Color::find($this->argument('id'));
            if ($color) {
                $color->delete();
                $this->info("Color {$color->name} deleted successfully");
            } else {
                $this->error('Color not found');
            }
        } catch (DatabaseConnectionException|MissingTableException $e) {
            $this->error('Error deleting color');
            $this->error($e->getMessage());
        }
    }
}
