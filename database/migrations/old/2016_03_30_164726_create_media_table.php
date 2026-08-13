<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('medias',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->integer('gallery_id');
            $table->text('content')->nullable();
            $table->string('name', 100);
            $table->string('slug', 45);
            $table->string('target', 200)->nullable();
            $table->integer('created_at')->default(0);
            $table->integer('updated_at')->nullable();
            $table->boolean('photo');
            $table->integer('rank')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('medias');
    }

}
