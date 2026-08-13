<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('facebook_link', 255);
            $table->string('twitter_link', 255);
            $table->string('youtube_link', 255);
            $table->string('pinterest_link', 255);
            $table->string('instagram_link', 255);
            $table->text('home_intro');
            $table->text('home_outro');
            $table->text('footer_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contents');
    }
}
