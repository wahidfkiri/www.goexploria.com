<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaTagTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('medias_tags',
            function(Blueprint $table) {
            $table->integer('tag_id');
            $table->integer('media_id');
            $table->primary(array('tag_id', 'media_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('medias_tags');
    }

}
