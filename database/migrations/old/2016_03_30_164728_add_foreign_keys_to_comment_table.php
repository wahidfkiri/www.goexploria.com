<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCommentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('comments',
            function(Blueprint $table) {
            $table->foreign('user_id', 'fk_user_comment')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('comments',
            function(Blueprint $table) {
            $table->dropForeign('fk_user_comment');


        });
    }

}
