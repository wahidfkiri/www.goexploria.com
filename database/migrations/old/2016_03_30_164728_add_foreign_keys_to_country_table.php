<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCountryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('countries',
            function(Blueprint $table) {
            $table->foreign('continent_id', 'fk_continent_id')->references('id')->on('continents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('countries',
            function(Blueprint $table) {
            $table->dropForeign('fk_continent_id');
        });
    }

}
