<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMediaLikeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('medias_likes',
            function(Blueprint $table) {
            $table->foreign('user_id', 'fk_like_media_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('media_id', 'fk_media_like_id')->references('id')->on('medias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('medias_likes',
            function(Blueprint $table) {
            $table->dropForeign('fk_media_like_id');
            $table->dropForeign('fk_like_media_id');
        });
    }

}
