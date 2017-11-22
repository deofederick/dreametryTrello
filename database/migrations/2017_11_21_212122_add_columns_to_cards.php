<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards', function($table){
            $table->date('date_started');
            $table->date('date_finished');
            $table->string('url');
            $status->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards', function($table){
            $table->date('date_started');
            $table->date('date_finished');
            $table->string('url');
            $status->string('status');
        });
    }
}
