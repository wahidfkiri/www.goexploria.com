<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanyActivityTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies_activities',
            function(Blueprint $table) {
            $table->foreign('activity_id', 'fk_activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('company_id', 'fk_company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('companies_activities',
            function(Blueprint $table) {
            $table->dropForeign('fk_activity_id');
            $table->dropForeign('fk_company_id');
        });
    }

}
