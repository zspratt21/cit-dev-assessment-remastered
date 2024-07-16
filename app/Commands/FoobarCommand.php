<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class FoobarCommand extends Command
{
    protected $signature = 'foobar {limit=100}';

    protected $description = 'This is a foobar command';

    public function handle(): void
    {
        $limit = (int) $this->argument('limit') ?: 100;
        $foobar_rows = [];
        for ($i = 1; $i <= $limit; $i++) {
            $check_a = $i % 3 === 0;
            $check_b = $i % 5 === 0;
            $foo = match (true) {
                $check_a && $check_b => 'foobar',
                $check_a => 'foo',
                $check_b => 'bar',
                default => $i,
            };
            $foobar_rows[] = [$i, $foo];
        }
        $this->table(['Value', 'Output'], $foobar_rows);
    }
}
