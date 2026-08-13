<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaCommentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('medias_comments',
            function(Blueprint $table) {
            $table->integer('comment_id');
            $table->integer('media_id');
            $table->primary(array('comment_id', 'media_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('medias_comments');
    }

}
