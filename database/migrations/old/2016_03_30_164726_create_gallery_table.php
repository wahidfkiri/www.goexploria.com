<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('galleries',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->text('content')->nullable();
            $table->string('name', 100);
            $table->string('slug', 45);
            $table->string('target', 200)->nullable();
            $table->boolean('is_slider')->nullable();
            $table->integer('created_at')->default(0);
            $table->integer('updated_at')->nullable();
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('galleries');
    }

}
