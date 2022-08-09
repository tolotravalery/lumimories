<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInformationsToProfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profils', function (Blueprint $table) {
            $table->string('lieuRepos',20)->nullable();
            $table->string('nomCimitiere',200)->nullable();
            $table->string("carteCimitiere")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profils', function (Blueprint $table) {
            $table->dropColumn('lieuRepos');
            $table->dropColumn('nomCimitiere');
            $table->dropColumn('carteCimitiere');
        });
    }
}
