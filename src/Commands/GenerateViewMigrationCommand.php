<?php

namespace CodeZero\LaravelSqlViews\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;

class GenerateViewMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:sql-view {viewName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an empty MySQL view migration file';


    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * @var Composer
     */
    private $composer;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
        $this->composer = app()['composer'];
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $viewName = Str::snake($this->argument('viewName'));

        if ($this->files->exists($path = $this->getPath($viewName))) {
            $this->error('View file already exists!');
            exit;
        }

        $this->makeDirectory($path);


        $stub = $this->files->get(__DIR__ . '/../stubs/ViewMigration.stub');

        $stub = Str::replaceArray('{{className}}', [studly_case($viewName)], $stub);
        $stub = Str::replaceArray('{{viewName}}', [$viewName], $stub);

        $this->files->put($path, $stub);

        $this->info('Empty View migration file created successfully.');

        $this->composer->dumpAutoloads();
    }

    /**
     * Get the path to where we should store the migration.
     *
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        return base_path() . '/database/views/' . $name . '.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string $path
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }
}
