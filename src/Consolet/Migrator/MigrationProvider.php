<?php namespace Consolet\Migrator;

use Consolet\Application;
use Consolet\CommandProviderInterface;
use Consolet\Migrator;
use Consolet\Migrator\Commands\MigrateCommand;
use Consolet\Migrator\Commands\MigrateMakeCommand;
use Consolet\Migrator\Commands\MigrateRefreshCommand;
use Consolet\Migrator\Commands\MigrateResetCommand;
use Consolet\Migrator\Commands\MigrateRollBackCommand;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Console\Migrations\InstallCommand;
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
            new MigrateCommand($migrator),
            new MigrateRollbackCommand($migrator),
            new MigrateResetCommand($migrator),
            new MigrateRefreshCommand,
            new MigrateMakeCommand($creator),
            new InstallCommand($repository),
        ];
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
