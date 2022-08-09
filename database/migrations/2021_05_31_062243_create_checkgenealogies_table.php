<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckgenealogiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkgenealogies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('profil_id')->unsigned()->index();
            $table->foreign('profil_id')->references('id')->on('profils')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('profil_value_id')->unsigned()->index();
            $table->foreign('profil_value_id')->references('id')->on('profils')->onDelete('cascade')->onUpdate('cascade');
            $table->string('status');
            $table->boolean('valider')->default(false);
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
        Schema::dropIfExists('checkgenealogies');
    }
}
