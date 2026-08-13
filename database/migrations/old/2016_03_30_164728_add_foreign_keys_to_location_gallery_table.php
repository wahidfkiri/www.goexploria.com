<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLocationGalleryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('locations_galleries',
            function(Blueprint $table) {
            $table->foreign('location_id', 'fk_location_gallery_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('gallery_id', 'fk_gallery_location_id')->references('id')->on('galleries')->onDelete('cascade');
            $table->foreign('language_id', 'fk_language_location_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('locations_galleries',
            function(Blueprint $table) {
            $table->dropForeign('fk_location_gallery_id');
            $table->dropForeign('fk_gallery_location_id');
            $table->dropForeign('fk_language_location_id');
        });
    }

}
