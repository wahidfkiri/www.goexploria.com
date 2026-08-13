<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMediaCommentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('medias_comments',
            function(Blueprint $table) {
            $table->foreign('comment_id', 'fk_comment_media_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('media_id', 'fk_media_comment_id')->references('id')->on('medias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('medias_comments',
            function(Blueprint $table) {
            $table->dropForeign('fk_media_comment_id');
            $table->dropForeign('fk_comment_media_id');
        });
    }

}
