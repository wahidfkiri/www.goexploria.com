<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLocationLanguageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('locations_languages',
            function(Blueprint $table) {
            $table->foreign('language_id', 'fk_l_l_language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('location_id', 'fk_l_l_location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('locations_languages',
            function(Blueprint $table) {
            $table->dropForeign('fk_l_l_language_id');
            $table->dropForeign('fk_l_l_location_id');
        });
    }

}
