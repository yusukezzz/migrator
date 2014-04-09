<?php namespace Consolet\Migrations;

use Consolet\Application;
use Consolet\CommandProviderInterface;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Console\Migrations\InstallCommand;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Database\Console\Migrations\RefreshCommand;
use Illuminate\Database\Console\Migrations\ResetCommand;
use Illuminate\Database\Console\Migrations\RollbackCommand;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;

class MigrationProvider implements CommandProviderInterface
{
    public function registerCommands(Application $console)
    {
        $container = $console->getContainer();
        $resolver = $this->getConnectionResolver($container['config']);
        $repository = new DatabaseMigrationRepository($resolver, $container['config']['database.migrations']);
        $migrator = new Migrator($repository, $resolver, $container['files']);
        $creator = new MigrationCreator($container['files']);
        $commands = [
            new MigrateCommand($migrator, null),
            new RollbackCommand($migrator),
            new ResetCommand($migrator),
            new RefreshCommand,
            new InstallCommand($repository),
            new MigrateMakeCommand($creator, null),
        ];
        foreach ($commands as $c) {
            $c->setLaravel($container);
        }
        $console->addCommands($commands);
    }

    /**
     * @param $config
     * @return \Illuminate\Database\ConnectionResolverInterface
     */
    protected function getConnectionResolver($config)
    {
        $name = $config['database.default'];
        $conn = $config['database.connections'][$name];
        $db = new Manager();
        $db->addConnection($conn);
        return $db->getDatabaseManager();
    }
}
