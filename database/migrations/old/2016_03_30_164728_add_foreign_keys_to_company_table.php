<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies',
            function(Blueprint $table) {
            $table->foreign('coordinate_id', 'fk_coordinate_id')->references('id')->on('coordinates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('companies',
            function(Blueprint $table) {
            $table->dropForeign('fk_coordinate_id');
        });
    }

}
