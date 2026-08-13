<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('languages',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->char('locale', 2);
            $table->string('name_en', 100);
            $table->integer('statut')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('languages');
    }

}
