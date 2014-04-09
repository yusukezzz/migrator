<?php namespace Consolet\Migrations;

class Migrator extends \Illuminate\Database\Migrations\Migrator
{
    public function resolve($file)
    {
        /* @var $class \Consolet\Migrations\Migration */
        $class = parent::resolve($file);
        $class::setSchemaOnce($this->resolveConnection()->getSchemaBuilder());
        return $class;
    }
}
