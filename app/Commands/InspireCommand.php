<?php

namespace App\Commands;

use App\Color;
use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

use function Termwind\render;
use function Termwind\style;

class InspireCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'inspire {name=Artisan}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        style('rc')->color('#FFFFFF');
        try {
            if (Color::exists()) {
                $random_color = Color::inRandomOrder()->first()->hex;
                style('rc')->color($random_color);
            }
        } catch (DatabaseConnectionException|MissingTableException) {
            $this->warn('Run migrations and add some colors to get a random color when running this command.');
        }
        render(<<<'HTML'
            <div class="py-1 ml-2">
                <div class="px-1 bg-rc text-black">Laravel Zero</div>
                <em class="ml-1">
                  Simplicity is the ultimate sophistication.
                </em>
            </div>
        HTML);
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
