<?php

use Illuminate\Database\Schema\Blueprint;
use \Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        self::$schema->create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->integer('age');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        self::$schema->drop('users');
    }

}
