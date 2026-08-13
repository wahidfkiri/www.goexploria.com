<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsHomesliderToGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
          $table->boolean('is_homeslider')->after('is_slider')->nullable();
          $table->boolean('is_home')->after('is_homeslider')->nullable();
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
          $table->dropColumn('is_homeslider');
          $table->dropColumn('is_home');
        });
    }
}
