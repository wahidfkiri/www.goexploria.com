<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanyGalleryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies_galleries',
            function(Blueprint $table) {
            $table->foreign('company_id', 'fk_company_gallery_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('gallery_id', 'fk_gallery_company_id')->references('id')->on('galleries')->onDelete('cascade');
            $table->foreign('language_id', 'fk_gallery_language_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('companies_galleries',
            function(Blueprint $table) {
            $table->dropForeign('fk_gallery_company_id');
            $table->dropForeign('fk_company_gallery_id');
            $table->dropForeign('fk_gallery_language_id');
        });
    }

}
