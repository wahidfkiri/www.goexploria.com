<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInfolettreTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('infolettres',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id');
            $table->string('name', 45)->unique();
            $table->text('content');
            $table->integer('sended_at')->nullable();
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
        Schema::drop('infolettres');
    }

}
