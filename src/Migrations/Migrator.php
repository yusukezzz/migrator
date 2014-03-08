<?php namespace Migrations;

class Migrator extends \Illuminate\Database\Migrations\Migrator
{
    public function resolve($file)
    {
        /* @var $class \Migrations\Migration */
        $class = parent::resolve($file);
        $class::setSchemaOnce($this->resolveConnection()->getSchemaBuilder());
        return $class;
    }
}
