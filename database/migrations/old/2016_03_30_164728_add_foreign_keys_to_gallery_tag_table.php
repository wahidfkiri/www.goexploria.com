<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGalleryTagTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('galleries_tags',
            function(Blueprint $table) {
            $table->foreign('tag_id', 'fk_tag_gallery_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('gallery_id', 'fk_gallery_tag_id')->references('id')->on('galleries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('galleries_tags',
            function(Blueprint $table) {
            $table->dropForeign('fk_gallery_tag_id');
            $table->dropForeign('fk_tag_gallery_id');
        });
    }

}
