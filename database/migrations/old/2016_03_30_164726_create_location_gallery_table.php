<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationGalleryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('locations_galleries',
            function(Blueprint $table) {
            $table->integer('location_id');
            $table->integer('gallery_id');
            $table->integer('language_id');
            $table->primary(array('location_id', 'gallery_id', 'language_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('locations_galleries');
    }

}
