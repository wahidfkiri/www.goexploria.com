<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMenuFieldsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('config_menu_position')->after('config_custom_css')->nullable();
            $table->string('config_menu_min_height')->after('config_menu_position')->nullable();
            $table->boolean('config_menu_has_logo')->after('config_menu_min_height')->nullable();
            $table->string('config_menu_logo_position')->after('config_menu_has_logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('config_menu_position');
            $table->dropColumn('config_menu_min_height');
            $table->dropColumn('config_menu_has_logo');
            $table->dropColumn('config_menu_logo_position');
        });
    }
}
