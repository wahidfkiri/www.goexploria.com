<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGalleryCommentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('galleries_comments',
            function(Blueprint $table) {
            $table->foreign('comment_id', 'fk_comment_gallery_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('gallery_id', 'fk_gallery_comment_id')->references('id')->on('galleries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('galleries_comments',
            function(Blueprint $table) {
            $table->dropForeign('fk_gallery_comment_id');
            $table->dropForeign('fk_comment_gallery_id');
        });
    }

}
