<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanyPageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies_pages',
            function(Blueprint $table) {
            $table->foreign('company_id', 'fk_l_page_company_id')->references('id')->on('companies');
             $table->foreign('page_id', 'fk_l_company_page_id')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('companies_pages',
            function(Blueprint $table) {
            $table->dropForeign('fk_l_page_company_id');
            $table->dropForeign('fk_l_company_page_id');
        });
    }

}
