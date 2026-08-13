<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryCommentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('galleries_comments',
            function(Blueprint $table) {
            $table->integer('comment_id');
            $table->integer('gallery_id');
            $table->primary(array('comment_id', 'gallery_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('galleries_comments');
    }

}
