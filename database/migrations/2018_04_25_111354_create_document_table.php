<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
          $table->increments('id');
          $table->string('foreign_table')->nullable()->default(null);
          $table->integer('foreign_id')->nullable()->default(null);
          $table->string("filename");
          $table->string("name")->nullable()->default(null);
          $table->string("description")->nullable()->default(null);
          $table->string("type");
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('documents');
    }
}
