<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLocationPageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('locations_pages',
            function(Blueprint $table) {
            $table->foreign('location_id', 'fk_l_page_location_id')->references('id')->on('locations');
             $table->foreign('page_id', 'fk_l_location_page_id')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('locations_pages',
            function(Blueprint $table) {
            $table->dropForeign('fk_l_page_location_id');
            $table->dropForeign('fk_l_location_page_id');
        });
    }

}
