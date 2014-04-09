<?php namespace Consolet\Migrations;

abstract class Migration extends \Illuminate\Database\Migrations\Migration
{
    /**
     * Schema builder instance
     *
     * @var \Illuminate\Database\Schema\Builder
     */
    protected static $schema;

    /**
     * Set schema builder at once
     *
     * @param \Illuminate\Database\Schema\Builder $schema
     */
    public static function setSchemaOnce($schema)
    {
        if (is_null(static::$schema)) static::$schema = $schema;
    }
}
