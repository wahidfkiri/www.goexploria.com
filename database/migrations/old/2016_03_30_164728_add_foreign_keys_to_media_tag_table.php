<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMediaTagTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('medias_tags',
            function(Blueprint $table) {
            $table->foreign('tag_id', 'fk_tag_media_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('media_id', 'fk_media_tag_id')->references('id')->on('medias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('medias_tags',
            function(Blueprint $table) {
            $table->dropForeign('fk_media_tag_id');
            $table->dropForeign('fk_tag_media_id');
        });
    }

}
