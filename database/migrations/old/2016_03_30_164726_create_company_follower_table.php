<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyFollowerTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('companies_followers',
            function(Blueprint $table) {
            $table->integer('company_id');
            $table->string('email', 100);
            $table->string('name', 50);
            $table->primary(array('company_id', 'email'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('companies_followers');
    }

}
