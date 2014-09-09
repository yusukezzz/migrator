<?php namespace Consolet;

class Migrator extends \Illuminate\Database\Migrations\Migrator
{
    public function resolve($file)
    {
        /* @var $class \Consolet\Migrator\Migration */
        $class = parent::resolve($file);
        $class::setSchemaOnce($this->resolveConnection(null)->getSchemaBuilder());
        return $class;
    }
}
