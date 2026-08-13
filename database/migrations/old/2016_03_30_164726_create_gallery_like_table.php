<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryLikeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('galleries_likes',
            function(Blueprint $table) {
            $table->integer('gallery_id');
            $table->integer('user_id');
            $table->boolean('like');
            $table->primary(array('gallery_id', 'user_id'));
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('galleries_likes');
    }

}
