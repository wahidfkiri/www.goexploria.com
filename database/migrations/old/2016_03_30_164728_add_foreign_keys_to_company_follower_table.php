<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanyFollowerTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies_followers',
            function(Blueprint $table) {
            $table->foreign('company_id', 'fk_c_f_company')->references('id')->on('companies');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('companies_followers',
            function(Blueprint $table) {
            $table->dropForeign('fk_c_f_company');
        });
    }

}
