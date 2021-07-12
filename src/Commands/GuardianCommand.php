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
    protected $signature = 'guardian {--action= : `import` or `export`} {--model= : actions|pages|groups} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import/Export guardian data';

    protected $actionInput, $modelInput;

    protected $actions = ['import', 'export'];

    protected $models = [
        'actions',
        'pages',
        'groups',
    ];


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->getOptionsInput();
        $this->validateOptionValue();
        $this->executeAction();
    }

    /**
     * Execute guardian action
     *
     * @return void
     */
    public function executeAction()
    {
        foreach ($this->modelInput as $model) {
            call_user_func_array([$this, $this->actionInput], [$model]);
        }
    }

    /**
     * Import data
     *
     * @param string $model
     *
     * @return void
     */
    public function import($model)
    {
        app(guardian("guardian.models.{$model}"))
        ->insertDuplicate(
            guardian($model),
            guardian_upsert("{$model}.insert"),
            guardian_upsert("{$model}.update")
        );
    }

    /**
     * Export data
     *
     * @param string $model
     *
     * @return void
     */
    public function export($model)
    {
        $data = app(guardian("guardian.models.{$model}"))->except()->get()->toArray();
        $this->generateFile($model, $data);
    }

    /**
     * Generate exported file
     *
     * @param string $model
     * @param array $data
     *
     * @return void
     */
    public function generateFile(string $model, array $data)
    {
        $path = config_path('guardian');
        if (File::missing($path)) {
            File::makeDirectory($path);
        }
        $filePath = "{$path}/{$model}.php";

        File::put(
            $filePath,
            '<?php '.PHP_EOL.''.PHP_EOL.'return '.var_export($data, true).';'.PHP_EOL
        );
    }

    /**
     * Validate command options
     *
     * @return void
     */
    public function validateOptionValue()
    {
        if (false === in_array($this->actionInput, $this->actions)) {
            $this->error('Action value is invalid!');
            exit(0);
        }

        $this->modelInput = explode('|', $this->modelInput);
        if (false === empty(array_diff($this->modelInput, $this->models))) {
            $this->error('Model value is invalid!');
            exit(0);
        }
   
    }

    /**
     * Get option inputs
     *
     * @return void
     */
    public function getOptionsInput()
    {
        $this->actionInput = $this->getActionInput();
        $this->modelInput = $this->getModelInput();
    }

    /**
     * Get import input
     *
     * @return void
     */
    public function getActionInput()
    {
        return trim($this->option('action'));
    }

    /**
     * Get export input
     *
     * @return void
     */
    public function getModelInput()
    {
        return trim($this->option('model'));
    }
}
