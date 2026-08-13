<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsPubsliderDestinationAndListToGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->boolean('is_pubslider_destination')->after('is_home')->nullable();
            $table->boolean('is_pubslider_list')->after('is_home')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('is_pubslider_destination');
            $table->dropColumn('is_pubslider_list');
        });
    }
}
