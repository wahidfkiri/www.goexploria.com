<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGalleryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('galleries',
            function(Blueprint $table) {
            $table->foreign('user_id', 'fk_gallery_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('galleries',
            function(Blueprint $table) {
            $table->dropForeign('fk_gallery_user_id');
        });
    }

}
