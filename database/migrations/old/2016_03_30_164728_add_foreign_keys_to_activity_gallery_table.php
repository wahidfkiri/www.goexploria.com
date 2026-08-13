<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToActivityGalleryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('activities_galleries',
            function(Blueprint $table) {
            $table->foreign('activity_id', 'fk_activity_gallery_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('gallery_id', 'fk_gallery_activity_id')->references('id')->on('galleries')->onDelete('cascade');
            $table->foreign('language_id', 'fk_gallery_language_id')->references('id')->on('languages')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('activities_galleries',
            function(Blueprint $table) {
            $table->dropForeign('fk_gallery_activity_id');
            $table->dropForeign('fk_activity_gallery_id');
            $table->dropForeign('fk_gallery_language_id');
        });
    }

}
