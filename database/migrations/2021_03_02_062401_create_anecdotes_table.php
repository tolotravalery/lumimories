<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnecdotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anecdotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("avis",500);
            $table->boolean("valider")->default(false);
            $table->string("photos",200)->nullable();
            $table->string("auteur");
            $table->string("email");
            $table->bigInteger('profil_id')->unsigned()->index();
            $table->foreign('profil_id')->references('id')->on('profils')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('anecdotes');
    }
}
