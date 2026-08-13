<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsletterHistoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('newsletters_histories',
            function(Blueprint $table) {
            $table->integer('newsletter_id');
            $table->integer('sended_at');
            $table->integer('user_id')->nullable();
            $table->primary(array('newsletter_id', 'sended_at'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('newsletters_histories');
    }

}
