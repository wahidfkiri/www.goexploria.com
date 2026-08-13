<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('companies',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 45);
            $table->string('slug', 45);
            $table->string('mail_news', 100);
            $table->integer('coordinate_id');
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
        Schema::drop('companies');
    }

}
