<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	if (!Schema::hasColumns('companies', [
	   'gallery_home',
	   'newsletter',
	   'slideshow_height',
	   'footer_text_color',
	   'home_content'])) {
	
          Schema::table('companies', function (Blueprint $table) {
              $table->tinyInteger('gallery_home')->after('mail_news');
	      $table->tinyInteger('newsletter')->after('gallery_home');
	      $table->integer('slideshow_height')->after('newsletter')->default(370);
	      $table->string('footer_text_color', 4)->after('slideshow_height');
	      $table->text('home_content')->after('footer_text_color');
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
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('gallery_home');
	    $table->dropColumn('newsletter');
	    $table->dropColumn('slideshow_height');
	    $table->dropColumn('home_content');
	    $table->dropColumn('footer_text_color');
	    
        });
    }
}
