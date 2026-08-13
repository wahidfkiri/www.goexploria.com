<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMediaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('medias',
            function(Blueprint $table) {
            $table->foreign('gallery_id', 'fk_gallery_id')->references('id')->on('galleries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('medias',
            function(Blueprint $table) {
            $table->dropForeign('fk_gallery_id');
        });
    }

}
