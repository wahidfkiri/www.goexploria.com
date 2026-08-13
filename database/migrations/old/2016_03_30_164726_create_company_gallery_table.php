<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyGalleryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('companies_galleries',
            function(Blueprint $table) {
            $table->integer('company_id');
            $table->integer('gallery_id');
            $table->integer('language_id');
            $table->primary(array('company_id', 'gallery_id', 'language_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('companies_galleries');
    }

}
