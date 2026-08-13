<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToNewsletterHistoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('newsletters_histories',
            function(Blueprint $table) {
            $table->foreign('newsletter_id', 'fk_newsletter_id')->references('id')->on('newsletters');
            $table->foreign('user_id', 'fk_n_h_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('newsletters_histories',
            function(Blueprint $table) {
            $table->dropForeign('fk_newsletter_id');
            $table->dropForeign('fk_n_h_user_id');
        });
    }

}
