<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentToGalleries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('galleries', function (Blueprint $table) {
          $table->integer('page_id')->after('is_home')->nullable();

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
          $table->dropColumn("page_id");
      });
    }
}
