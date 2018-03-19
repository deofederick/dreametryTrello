<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('authentications')){
            Schema::create('authentications', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('auth_id')->unique();
                $table->integer('role_id');
                $table->string('has_access');
                $table->timestamps();
            });      
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
