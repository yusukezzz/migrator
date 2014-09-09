<?php namespace Consolet\Migrator\Commands;

use Consolet\Command;

class BaseCommand extends Command
{
    protected function getMigrationPath()
    {
        $path = $this->input->getOption('path');

        if ( ! is_null($path)) {
            return $this->getWorkingPath() . DIRECTORY_SEPARATOR . $path;
        }
        $c = $this->container['config'];
        return $c['paths.migrations'];
    }
} 