<?php namespace Migrations;

use Illuminate\Database\Console\Migrations\InstallCommand;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Database\Console\Migrations\RefreshCommand;
use Illuminate\Database\Console\Migrations\ResetCommand;
use Illuminate\Database\Console\Migrations\RollbackCommand;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;

class MigrationProvider
{
    /**
     * @var \Symfony\Component\Console\Application
     */
    protected $console;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    protected $resolver;

    /**
     * @var DatabaseMigrationRepository
     */
    protected $repository;

    /**
     * Migration repository table name
     *
     * @var string
     */
    protected $table = 'migrations';

    /**
     * @var \Illuminate\Database\Migrations\DatabaseMigrationRepository
     */
    protected $migrator;

    public function __construct(\Symfony\Component\Console\Application $console, $container)
    {
        $this->console = $console;
        $this->container = $container;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function register()
    {
        $this->registerRepository();
        $this->registerMigrator();
        $this->registerCommands();
    }

    protected function registerRepository()
    {
        $this->resolver = $this->container['db']->getDatabaseManager();
        $this->repository = new DatabaseMigrationRepository($this->resolver, $this->table);
    }

    protected function registerMigrator()
    {
        $this->migrator = new Migrator($this->repository, $this->resolver, $this->container['files']);
    }

    protected function registerCommands()
    {
        $creator = new \Migrations\MigrationCreator($this->container['files']);
        $commands = [
            new MigrateCommand($this->migrator, null),
            new RollbackCommand($this->migrator),
            new ResetCommand($this->migrator),
            new RefreshCommand,
            new InstallCommand($this->repository),
            new MigrateMakeCommand($creator, null),
        ];
        foreach ($commands as $c) {
            $c->setLaravel($this->container);
        }
        $this->console->addCommands($commands);
    }
}
