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
            $table->string('nomDeJeuneFille',200)->nullable();
            $table->string('surnom',200)->nullable();
            $table->string("paysDeNaissance")->nullable();
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
            $table->dropColumn('nomDeJeuneFille');
            $table->dropColumn('surnom');
            $table->dropColumn('paysDeNaissance');
        });
    }
}
