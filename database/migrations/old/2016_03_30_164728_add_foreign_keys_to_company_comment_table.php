<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompanyCommentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('companies_comments',
            function(Blueprint $table) {
            $table->foreign('company_id', 'fk_company_comment_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('companies_comments',
            function(Blueprint $table) {
            $table->dropForeign('fk_company_comment_id');
        });
    }

}
