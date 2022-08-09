<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignalerAnecdotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signalerAnecdotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('raison');
            $table->bigInteger('anecdote_id')->unsigned()->index();
            $table->foreign('anecdote_id')->references('id')->on('anecdotes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('signalerAnecdotes');
    }
}
