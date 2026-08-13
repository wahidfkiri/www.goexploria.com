<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentLikeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('comments_likes',
            function(Blueprint $table) {
            $table->integer('comment_id');
            $table->integer('user_id');
            $table->boolean('like');
            $table->primary(array('comment_id', 'user_id'));

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('comments_likes');
    }

}
