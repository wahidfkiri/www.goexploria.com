<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities',
            function(Blueprint $table) {
            $table->foreign('category_id', 'fk_activity_category_id')->references('id')->on('activities_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities',
            function(Blueprint $table) {
            $table->dropForeign('fk_activity_category_id');
        });
    }
}
