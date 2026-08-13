<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('companies_users',
            function(Blueprint $table) {
            $table->integer('user_id')->index('fk_c_b_user_id_idx');
            $table->integer('company_id');
            $table->primary(['company_id', 'user_id']);
            $table->integer('created_at');
            $table->integer('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('companies_users');
    }

}
