<?php namespace Consolet\Migrations;

class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator
{
    public function getStubPath()
    {
        return __DIR__ . '/stubs';
    }
}
