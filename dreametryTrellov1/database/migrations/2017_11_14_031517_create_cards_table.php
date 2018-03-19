<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cards')){
            Schema::create('cards', function (Blueprint $table) {
                $table->increments('id');
                $table->string('card_id')->unique();
                $table->timestamps();
                $table->date('date_started');
                $table->date('date_finished');
                $table->string('url');
                $table->string('status');
                $table->integer('list_id');
                $table->string('card_name');
                $table->integer('user_id');
                $table->string('label');
                $table->string('from_list_id');
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
        Schema::dropIfExists('cards');
    }
}
