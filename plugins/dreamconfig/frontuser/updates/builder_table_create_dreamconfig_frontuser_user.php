<?php namespace DreamConfig\FrontUser\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDreamconfigFrontUserUser extends Migration
{
    public function up()
    {
        Schema::create('dreamconfig_frontuser_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 50);
            $table->string('surname', 50);
            $table->string('email', 50);
            $table->string('phone', 50)->nullable();
            $table->string('password', 128);
            $table->string('persist_code', 128);
            $table->string('activation_code', 50);
            $table->string('is_activated', 50);
            $table->string('activated_at', 50);
            $table->dateTime('last_login');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('dreamconfig_frontuser_user');
    }
}
