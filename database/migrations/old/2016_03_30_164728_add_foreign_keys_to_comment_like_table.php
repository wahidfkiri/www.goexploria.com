<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCommentLikeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('comments_likes',
            function(Blueprint $table) {
            $table->foreign('user_id', 'fk_like_comment_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('comment_id', 'fk_comment_like_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('comments_likes',
            function(Blueprint $table) {
            $table->dropForeign('fk_comment_like_id');
            $table->dropForeign('fk_like_comment_id');
        });
    }

}
