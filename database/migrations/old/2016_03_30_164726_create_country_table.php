<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('countries',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 2)->unique();
            $table->string('name', 45);
            $table->integer('continent_id')->index('fk_c_continent_id_idx');
            $table->boolean('is_activated')->default(false);
            $table->string('slug', 45)->unique();
            $table->integer('rank')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('countries');
    }

}
