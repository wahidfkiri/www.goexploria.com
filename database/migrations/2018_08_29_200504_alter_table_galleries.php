<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGalleries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	if (!Schema::hasColumn('galleries', 'is_carousel') ) {
           Schema::table('galleries', function (Blueprint $table) {
             $table->tinyInteger('is_carousel')->after('is_home')->nullable();
	   });
	}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('is_carousel');
        });
    }
}
