<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContinentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('continents',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 2)->unique();
            $table->string('name', 45);
            $table->integer('rank')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('continents');
    }

}
