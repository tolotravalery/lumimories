<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("nom",200);
            $table->string("prenoms",200);
            $table->string("photoProfil");
            $table->string("sexe",5);
            $table->string("pays");
            $table->string("nomMere")->nullable();
            $table->string("nomPere")->nullable();
            $table->string("categorie")->nullable();
            $table->boolean("star")->default(false);
            $table->date("dateDeces");
            $table->date("dateNaissance");
            $table->text("biographie")->nullable();
            $table->text("motifDeces")->nullable();
            $table->integer("nbreBougie")->default(0);
            $table->text("monument")->nullable();
            $table->text("lieuDeRepos")->nullable();
            $table->boolean("validerParAdmin")->default(false);
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('profils');
    }
}
