<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaLikeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('medias_likes',
            function(Blueprint $table) {
            $table->integer('media_id');
            $table->integer('user_id');
            $table->boolean('like');
            $table->primary(array('media_id', 'user_id'));

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('medias_likes');
    }

}
