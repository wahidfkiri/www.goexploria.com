<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfigsFieldsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('config_top_text_color')->after('topcolor')->nullable();
            $table->string('config_top_link_color')->after('config_top_text_color')->nullable();
            $table->string('config_top_link_hover_color')->after('config_top_link_color')->nullable();
            $table->boolean('config_show_top_title')->after('config_top_link_hover_color')->nullable();
            $table->boolean('config_show_top_phone')->after('config_show_top_title')->nullable();
            $table->boolean('config_show_top_email')->after('config_show_top_phone')->nullable();
            $table->string('config_top_text')->after('config_show_top_email')->nullable();
            $table->string('config_menu_back_color')->after('config_top_text')->nullable();
            $table->string('config_menu_link_color')->after('config_menu_back_color')->nullable();
            $table->string('config_menu_link_hover_color')->after('config_menu_link_color')->nullable();
            $table->string('config_footer_text_color')->after('topcolor')->nullable();
            $table->string('config_footer_link_color')->after('config_top_text_color')->nullable();
            $table->string('config_footer_link_hover_color')->after('config_top_link_color')->nullable();
            $table->text('config_custom_css')->after('config_menu_link_hover_color')->nullable();
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
            $table->dropColumn('config_top_text_color');
            $table->dropColumn('config_top_link_color');
            $table->dropColumn('config_top_link_hover_color');
            $table->dropColumn('config_show_top_title');
            $table->dropColumn('config_show_top_phone');
            $table->dropColumn('config_show_top_email');
            $table->dropColumn('config_top_text');
            $table->dropColumn('config_menu_back_color');
            $table->dropColumn('config_menu_link_color');
            $table->dropColumn('config_menu_link_hover_color');
            $table->dropColumn('config_footer_text_color');
            $table->dropColumn('config_footer_link_color');
            $table->dropColumn('config_footer_link_hover_color');
            $table->dropColumn('config_custom_css');
        });
    }
}
