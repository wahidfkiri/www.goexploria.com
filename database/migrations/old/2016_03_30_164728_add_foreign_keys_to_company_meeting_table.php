<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanyMeetingTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies_meetings', function(Blueprint $table) {
            $table->foreign('company_id', 'fk_c_m_company')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('companies_meetings', function(Blueprint $table) {
            $table->dropForeign('fk_c_m_company');
        });
    }
}
