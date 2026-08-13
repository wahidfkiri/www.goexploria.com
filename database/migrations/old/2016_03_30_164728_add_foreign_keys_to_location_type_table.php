<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLocationTypeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('locations_types',
            function(Blueprint $table) {
            $table->foreign('country_id', 'fk_l_t_country_code')->references('id')->on('countries');
            $table->foreign('parent_id', 'fk_l_t_parent_id')->references('id')->on('locations_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('locations_types',
            function(Blueprint $table) {
            $table->dropForeign('fk_l_t_country_code');
            $table->dropForeign('fk_l_t_parent_id');
        });
    }

}
