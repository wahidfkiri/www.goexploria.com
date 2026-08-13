<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToCountryPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries_pages',
            function(Blueprint $table) {
            $table->foreign('country_id', 'fk_l_page_country_id')->references('id')->on('countries');
             $table->foreign('page_id', 'fk_l_country_page_id')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries_pages',
            function(Blueprint $table) {
            $table->dropForeign('fk_l_page_country_id');
            $table->dropForeign('fk_l_country_page_id');
        });
    }
}
