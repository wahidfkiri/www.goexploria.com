<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanyUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies_users',
            function(Blueprint $table) {
            $table->foreign('company_id', 'fk_c_b_company_id')->references('id')->on('companies');
            $table->foreign('user_id', 'fk_c_b_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('companies_users',
            function(Blueprint $table) {
            $table->dropForeign('fk_c_b_company_id');
            $table->dropForeign('fk_c_b_user_id');
        });
    }

}
