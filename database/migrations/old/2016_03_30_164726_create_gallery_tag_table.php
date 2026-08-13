<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryTagTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('galleries_tags',
            function(Blueprint $table) {
            $table->integer('tag_id');
            $table->integer('gallery_id');
            $table->primary(array('tag_id', 'gallery_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('galleries_tags');
    }

}
