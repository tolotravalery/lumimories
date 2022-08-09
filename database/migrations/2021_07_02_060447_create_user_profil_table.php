<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profil', function (Blueprint $table) {
            $table->bigInteger('user_suivre_id')->unsigned()->index();
            $table->foreign('user_suivre_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('profil_suivre_id')->unsigned()->index();
            $table->foreign('profil_suivre_id')->references('id')->on('profils')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profil');
    }
}
