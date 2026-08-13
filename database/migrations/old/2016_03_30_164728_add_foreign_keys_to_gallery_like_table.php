<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGalleryLikeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('galleries_likes',
            function(Blueprint $table) {
            $table->foreign('user_id', 'fk_like_gallery_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gallery_id', 'fk_gallery_like_id')->references('id')->on('galleries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('galleries_likes',
            function(Blueprint $table) {
            $table->dropForeign('fk_gallery_like_id');
            $table->dropForeign('fk_like_gallery_id');
        });
    }

}
