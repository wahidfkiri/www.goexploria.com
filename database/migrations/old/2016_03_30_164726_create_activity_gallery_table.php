<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivityGalleryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('activities_galleries',
            function(Blueprint $table) {
            $table->integer('activity_id');
            $table->integer('gallery_id');
            $table->integer('language_id');
            $table->primary(array('activity_id', 'gallery_id', 'language_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('activities_galleries');
    }

}
