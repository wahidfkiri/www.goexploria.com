<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivityTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('activities',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 45);
            $table->string('slug', 45);
            $table->integer('category_id')->index('fk_activity_category_id_idx');
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
        Schema::drop('activities');
    }

}
