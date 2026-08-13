<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyActivityTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('companies_activities',
            function(Blueprint $table) {
            $table->integer('company_id');
            $table->integer('activity_id');
            $table->primary(['company_id', 'activity_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('companies_activities');
    }

}
