<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInfolettreTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('infolettres',
            function(Blueprint $table) {
            $table->foreign('company_id', 'fk_infolettre_company')->references('id')->on('companies');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('infolettres',
            function(Blueprint $table) {
            $table->dropForeign('fk_infolettre_company');
        });
    }

}
