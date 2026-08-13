<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries_galleries',
            function(Blueprint $table) {   
            $table->integer('country_id');   
            $table->integer('gallery_id');   
            $table->integer('language_id');
            $table->primary(['country_id', 'gallery_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('countries_galleries');
    }
}
