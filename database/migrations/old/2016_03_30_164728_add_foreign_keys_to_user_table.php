<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users',
            function(Blueprint $table) {
            $table->foreign('coordinate_id', 'fk_u_coordinate_id')->references('id')->on('coordinates');
            $table->foreign('type_id', 'fk_u_type_id')->references('id')->on('users_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users',
            function(Blueprint $table) {
            $table->dropForeign('fk_u_coordinate_id');
            $table->dropForeign('fk_u_type_id');
        });
    }

}
