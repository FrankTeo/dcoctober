<?php namespace DreamConfig\FrontUser\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDreamconfigFrontUserUsers extends Migration
{
    public function up()
    {
        Schema::rename('dreamconfig_frontuser_user', 'dreamconfig_frontuser_users');
        Schema::table('dreamconfig_frontuser_users', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::rename('dreamconfig_frontuser_users', 'dreamconfig_frontuser_user');
        Schema::table('dreamconfig_frontuser_user', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
}
