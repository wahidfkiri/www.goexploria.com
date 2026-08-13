<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('media_attrs',
          function(Blueprint $table) {
          $table->increments('id');
          //$table->integer('id');
          $table->integer('media_id');
          $table->string("attr");
          $table->string("value");
          $table->timestamp('created_at');
          $table->timestamp('updated_at');
          //$table->primary("id");
          $table->foreign("media_id", "fk_media_attrs_medias_fk")
                ->references('id')
                ->on('medias')
                ->onDelete("cascade");
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_attrs', function(Blueprint $table){
          $table->dropForeign("fk_media_attrs_medias_fk");
        });
        Schema::drop('media_attrs');
    }
}
