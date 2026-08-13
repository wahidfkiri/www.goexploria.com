<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCoordinateTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('coordinates',
            function(Blueprint $table) {
            $table->foreign('location_id', 'fk_coordinate_location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('coordinates',
            function(Blueprint $table) {
            $table->dropForeign('fk_coordinate_location_id');
        });
    }

}
