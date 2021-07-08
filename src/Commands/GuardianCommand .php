<?php

namespace Cuongnd88\LaraGuardian\Commands;

use Illuminate\Console\Command;
use File;

class GuardianCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guardian:toArray';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export guardian data to array';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->exportMigrations();
    }

    public function generateGuardianConfig(array $data, string $file)
    {
        $path = config_path('guardian');
        if (File::missing($path)) {
            File::makeDirectory($path);
        }
        $filePath = "$path/$file.php";
        File::put(
            $filePath,
            '<?php '.PHP_EOL.''.PHP_EOL.'return '.var_export($data, true).';'.PHP_EOL
        );
    }
}
