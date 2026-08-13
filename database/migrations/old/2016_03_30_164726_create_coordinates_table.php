<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoordinatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('coordinates',
            function(Blueprint $table) {
            $table->integer('id', true);       
            $table->integer('location_id')->nullable();   
            $table->string('website', 150)->nullable();
            $table->string('mail', 150)->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('code_postal', 20)->nullable();
            $table->string('adresse', 100)->nullable();
            $table->string('fax', 20)->nullable();
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
        Schema::drop('coordinates');
    }

}
