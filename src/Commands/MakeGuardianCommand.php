<?php

namespace Cuongnd88\LaraGuardian\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;
use File;

class MakeGuardianCommand extends Command
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
        'database/migrations/2021_07_07_071409_create_pages_table.php',
        'database/migrations/2021_07_07_071620_create_actions_table.php',
        'database/migrations/2021_07_07_071710_create_group_table.php',
        'database/migrations/2021_07_07_071831_create_permissions_table.php',
        'database/migrations/2021_07_07_074719_create_roles_table.php',
    ];

    protected $models = [
        'Action.php',
        'Group.php',
        'Permission.php',
        'Page.php',
        'Role.php',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->exportMigrations();
            $this->exportModels();
            $this->exportMiddleware();
            $this->exportTraits();

            Artisan::call('migrate', [
                '--path' => $this->migrations
            ]);

            $this->info('Guardian created successfully');
        } catch (\Exception $e) {
            report($e);
            $this->error('Guardian created fail');
        }
    }

    public function exportTraits()
    {
        $path = app_path('Guardian/Traits');
        if (File::missing($path)) {
            File::makeDirectory($path, 0755, true);
        }
        copy(
            __DIR__."/../Guardian/Traits/HasGuardian.php",
            $path."/HasGuardian.php"
        );
    }

    /**
     * Export middleware
     *
     * @return void
     */
    public function exportMiddleware()
    {
        copy(
            __DIR__."/../Middleware/GuardianMiddleware.php",
            app_path('Http/Middleware/GuardianMiddleware.php')
        );
    }

    /**
     * Export migration
     *
     * @return void
     */
    public function exportMigrations()
    {
        foreach ($this->migrations as $value) {
            copy(
                __DIR__."/../../{$value}",
                base_path($value)
            );
        }
    }

    /**
     * Export model
     *
     * @return void
     */
    public function exportModels()
    {
        $path = app_path('Models');
        if (File::missing($path)) {
            File::makeDirectory($path);
        }
        foreach ($this->models as $value) {
            copy(
                __DIR__."/../Models/{$value}",
                $path."/".$value
            );
        }
    }
}
