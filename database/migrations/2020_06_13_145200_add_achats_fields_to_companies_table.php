<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAchatsFieldsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->float('achats_frais_transport', 8, 2)->after('achats_note')->nullable();
            $table->float('achats_reduction', 8, 2)->after('achats_frais_transport')->nullable();
            $table->text('achats_marche_a_suivre')->after('achats_reduction')->nullable();
            $table->text('achats_instructions')->after('achats_marche_a_suivre')->nullable();
            $table->string('achats_cheque')->after('achats_instructions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('achats_frais_transport');
            $table->dropColumn('achats_reduction');
            $table->dropColumn('achats_marche_a_suivre');
            $table->dropColumn('achats_instructions');
            $table->dropColumn('achats_cheque');
        });
    }
}
