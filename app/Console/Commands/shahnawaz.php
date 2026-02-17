<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class shahnawaz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:shahnawaz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $columns = \DB::select('DESCRIBE enrollments');
        $this->info('Enrollments table columns:');
        foreach ($columns as $column) {
            $this->info($column->Field . ' - ' . $column->Type);
        }
    }
}
