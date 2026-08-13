<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pages',
            function(Blueprint $table) {
            $table->integer('id', true);       
            $table->string('name', 100);
            $table->text('content');
            $table->integer('rank')->default(1);
            $table->boolean('is_visible')->default(false);
            $table->integer('created_at');
            $table->integer('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('pages');
    }

}
