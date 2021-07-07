<?php

namespace Cuongnd88\LaraGuardian\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class MakeGuardianCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:guardian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the guardian method';


    protected $migrations = [
        'databse/migrations/2021_07_07_071409_create_pages_table.php',
        'databse/migrations/2021_07_07_071620_create_actions_table.php',
        'databse/migrations/2021_07_07_071710_create_group_table.php',
        'databse/migrations/2021_07_07_071831_create_permissions_table.php',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->exportMigrations();
    }

    public function exportMigrations()
    {
        foreach ($this->migrations as $value) {
            // copy();
        }
    }
}
