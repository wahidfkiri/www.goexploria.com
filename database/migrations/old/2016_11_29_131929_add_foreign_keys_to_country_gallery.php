<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToCountryGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries_galleries',
            function(Blueprint $table) {
            $table->foreign('country_id', 'fk_gallery_country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('gallery_id', 'fk_country_gallery_id')->references('id')->on('galleries')->onDelete('cascade');
            $table->foreign('language_id', 'fk_gallery_language_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries_galleries',
            function(Blueprint $table) {
            $table->dropForeign('fk_gallery_country_id');
            $table->dropForeign('fk_country_gallery_id');
            $table->dropForeign('fk_gallery_language_id');
        });
    }
}
