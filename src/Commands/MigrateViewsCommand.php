<?php

namespace CodeZero\LaravelSqlViews\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;

class MigrateViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all the MySQL views';

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
        $viewFiles = $this->files->allFiles(base_path() . '/database/views/');
        foreach ($viewFiles as $viewFile) {
            $this->info("Detected $viewFile");
            $viewClassName = Str::studly(basename($viewFile, ".php"));
            $this->info("Processing class $viewClassName");
            $viewMigration = new $viewClassName();
            $viewMigration->generateView();
            $this->info("Processed $viewClassName");
        }
    }
}
