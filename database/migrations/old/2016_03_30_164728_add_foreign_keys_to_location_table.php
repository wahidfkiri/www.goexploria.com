<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLocationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('locations',
            function(Blueprint $table) {
            $table->foreign('type_id', 'fk_l_type_id')->references('id')->on('locations_types');
            $table->foreign('parent_id', 'fk_l_parent_id')->references('id')->on('locations');
            $table->foreign('coordinate_id', 'fk_l_coordinate_id')->references('id')->on('coordinates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('locations',
            function(Blueprint $table) {
            $table->dropForeign('fk_l_coordinate_id');
            $table->dropForeign('fk_l_type_id');
            $table->dropForeign('fk_l_parent_id');
        });
    }

}
